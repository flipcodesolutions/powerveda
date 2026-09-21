<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhonePeService
{
    protected string $env;
    protected string $merchantId;
    protected string $clientId;
    protected string $clientSecret;
    protected int $clientVersion;
    protected string $oauthUrl;
    protected string $payUrl;
    protected string $statusUrl;

    public function __construct()
    {
        $this->env = strtoupper(config('phonepe.env', 'SANDBOX'));
        $this->merchantId = config('phonepe.merchant_id', 'M23FMU2DDFY43');
        $this->clientId = config('phonepe.client_id', 'M23FMU2DDFY43_2602230918');
        $this->clientSecret = config('phonepe.client_secret', 'MWIyZmMzZTUtODFiMS00YWE2LTk5NWEtOTU1NzY4OGM1MjIx');
        $this->clientVersion = (int) config('phonepe.client_version', 1);

        $isProduction = in_array($this->env, ['PRODUCTION', 'LIVE']);
        $urlKey = $isProduction ? 'production' : 'sandbox';

        $this->oauthUrl = config("phonepe.urls.{$urlKey}.oauth");
        $this->payUrl = config("phonepe.urls.{$urlKey}.pay");
        $this->statusUrl = config("phonepe.urls.{$urlKey}.status");
    }

    /**
     * Create a configured HTTP client with automatic SSL fallback.
     */
    protected function http(): \Illuminate\Http\Client\PendingRequest
    {
        $client = Http::timeout(20);

        // In Sandbox / local development or if ca certificate file is missing on local system, bypass SSL verification
        $caInfo = ini_get('curl.cainfo');
        if ($this->env === 'SANDBOX' || app()->environment('local', 'testing') || empty($caInfo) || !file_exists($caInfo)) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    /**
     * Retrieve or generate a cached OAuth 2.0 Access Token.
     */
    public function getAccessToken(): ?string
    {
        $cacheKey = "phonepe_oauth_token_{$this->clientId}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->http()->asForm()->post($this->oauthUrl, [
                'client_id' => $this->clientId,
                'client_version' => $this->clientVersion,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['access_token'] ?? null;
                $expiresIn = (int) ($data['expires_in'] ?? 3600);

                if ($token) {
                    Cache::put($cacheKey, $token, max(60, $expiresIn - 120));
                    return $token;
                }
            }

            Log::error('PhonePe OAuth Token Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('PhonePe OAuth Token Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Initiate a standard Checkout payment session for an Order.
     *
     * @return array{success: bool, redirect_url?: string, order_id?: string, message?: string, data?: array}
     */
    public function initiatePayment(Order $order, string $redirectUrl): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to authenticate with PhonePe Payment Gateway.',
            ];
        }

        $amountInPaise = (int) round($order->total_amount * 100);

        $payload = [
            'merchantOrderId' => $order->order_number,
            'amount' => $amountInPaise,
            'expireAfter' => 1200, // 20 minutes expiration
            'meta' => [
                'udf1' => (string) $order->user_id,
                'udf2' => (string) $order->contactNo,
                'udf3' => (string) $order->recipient_name,
            ],
            'paymentFlow' => [
                'type' => 'PG_CHECKOUT',
                'message' => 'Payment for Power Veda Order #' . $order->order_number,
                'merchantUrls' => [
                    'redirectUrl' => $redirectUrl,
                ],
            ],
        ];

        try {
            $response = $this->http()->withHeaders([
                'Authorization' => 'O-Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->payUrl, $payload);

            $data = $response->json();

            if ($response->successful() && !empty($data['redirectUrl'])) {
                // Save payment details/state on order
                $order->update([
                    'payment_details' => json_encode($data),
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $data['redirectUrl'],
                    'order_id' => $data['orderId'] ?? null,
                    'data' => $data,
                ];
            }

            Log::error('PhonePe Initiate Payment Error', [
                'order' => $order->order_number,
                'status' => $response->status(),
                'response' => $data,
            ]);

            return [
                'success' => false,
                'message' => $data['message'] ?? 'Failed to initiate PhonePe payment session.',
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            Log::error('PhonePe Initiate Payment Exception', [
                'order' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Exception occurred while connecting to PhonePe gateway.',
            ];
        }
    }

    /**
     * Check Order Payment Status from PhonePe.
     *
     * @return array{success: bool, state: string, transaction_id?: string, data?: array}
     */
    public function checkOrderStatus(string $merchantOrderId): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'success' => false,
                'state' => 'UNKNOWN',
                'message' => 'Authentication token unavailable.',
            ];
        }

        $url = str_replace('{merchantOrderId}', $merchantOrderId, $this->statusUrl);

        try {
            $response = $this->http()->withHeaders([
                'Authorization' => 'O-Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->get($url);

            $data = $response->json();

            if ($response->successful()) {
                $state = strtoupper($data['state'] ?? 'PENDING');
                $transactionId = $data['paymentDetails']['transactionId'] ?? $data['orderId'] ?? null;

                return [
                    'success' => true,
                    'state' => $state,
                    'transaction_id' => $transactionId,
                    'data' => $data,
                ];
            }

            Log::error('PhonePe Check Status Error', [
                'merchantOrderId' => $merchantOrderId,
                'status' => $response->status(),
                'response' => $data,
            ]);

            return [
                'success' => false,
                'state' => strtoupper($data['state'] ?? 'FAILED'),
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            Log::error('PhonePe Check Status Exception', [
                'merchantOrderId' => $merchantOrderId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'state' => 'ERROR',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process Server-to-Server Webhook Payload.
     */
    public function processWebhook(array $payload): bool
    {
        Log::info('PhonePe Webhook Received', $payload);

        // Extract merchant order ID from webhook payload
        $merchantOrderId = $payload['merchantOrderId'] 
            ?? $payload['data']['merchantOrderId'] 
            ?? $payload['data']['merchantTransactionId'] 
            ?? null;

        if (!$merchantOrderId) {
            Log::warning('PhonePe Webhook Missing merchantOrderId', $payload);
            return false;
        }

        $order = Order::where('order_number', $merchantOrderId)->first();

        if (!$order) {
            Log::warning("PhonePe Webhook Order not found for: {$merchantOrderId}");
            return false;
        }

        // Verify state via Status API for complete security
        $statusResult = $this->checkOrderStatus($merchantOrderId);

        $state = $statusResult['state'] ?? strtoupper($payload['state'] ?? $payload['data']['state'] ?? 'PENDING');
        $transactionId = $statusResult['transaction_id'] ?? $payload['data']['transactionId'] ?? null;

        if (in_array($state, ['COMPLETED', 'SUCCESS'])) {
            $order->update([
                'payment_status' => 'Paid',
                'status' => 'Processing',
                'transaction_id' => $transactionId ?? $order->transaction_id,
                'payment_details' => json_encode($statusResult['data'] ?? $payload),
            ]);
            Log::info("PhonePe Order {$merchantOrderId} marked as Paid via Webhook.");
            return true;
        } elseif (in_array($state, ['FAILED', 'CANCELLED'])) {
            $order->update([
                'payment_status' => 'Failed',
                'status' => 'Cancelled',
                'payment_details' => json_encode($statusResult['data'] ?? $payload),
            ]);
            Log::info("PhonePe Order {$merchantOrderId} marked as Failed via Webhook.");
            return true;
        }

        return true;
    }
}
