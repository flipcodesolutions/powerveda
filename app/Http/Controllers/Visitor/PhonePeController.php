<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PhonePeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhonePeController extends Controller
{
    protected PhonePeService $phonePeService;

    public function __construct(PhonePeService $phonePeService)
    {
        $this->phonePeService = $phonePeService;
    }

    /**
     * Handle Customer Redirect Callback from PhonePe PG.
     */
    public function handleCallback(Request $request): RedirectResponse
    {
        Log::info('PhonePe Callback Received', $request->all());

        // Extract merchant order ID from various possible callback formats
        $merchantOrderId = $request->input('merchantOrderId')
            ?? $request->input('order_id')
            ?? $request->input('transactionId')
            ?? $request->query('order_number')
            ?? $request->query('merchantOrderId')
            ?? null;

        // If order number not in root, try decoding payload if base64 encoded
        if (!$merchantOrderId && $request->has('response')) {
            try {
                $decoded = json_decode(base64_decode($request->input('response')), true);
                $merchantOrderId = $decoded['data']['merchantTransactionId'] ?? $decoded['data']['merchantOrderId'] ?? null;
            } catch (\Throwable $e) {
                Log::warning('Failed decoding PhonePe base64 response', ['error' => $e->getMessage()]);
            }
        }

        if (!$merchantOrderId) {
            return redirect()->route('account', ['tab' => 'orders'])
                ->with('error', 'Payment session completed, but order reference was missing.');
        }

        $order = Order::where('order_number', $merchantOrderId)->first();

        if (!$order) {
            return redirect()->route('account', ['tab' => 'orders'])
                ->with('error', 'Unable to locate order #' . $merchantOrderId);
        }

        // Verify latest status with PhonePe Status API
        $statusResult = $this->phonePeService->checkOrderStatus($order->order_number);
        $state = $statusResult['state'] ?? 'PENDING';

        if (in_array($state, ['COMPLETED', 'SUCCESS'])) {
            $order->update([
                'payment_status' => 'Paid',
                'status' => 'Processing',
                'transaction_id' => $statusResult['transaction_id'] ?? $order->transaction_id,
                'payment_details' => json_encode($statusResult['data'] ?? []),
            ]);

            return redirect()->route('account', ['tab' => 'orders'])
                ->with('success', "🎉 Payment of ₹" . number_format($order->total_amount, 0) . " successfully verified via PhonePe! Order #{$order->order_number} is being processed.");
        } elseif (in_array($state, ['FAILED', 'CANCELLED'])) {
            $order->update([
                'payment_status' => 'Failed',
                'status' => 'Cancelled',
                'payment_details' => json_encode($statusResult['data'] ?? []),
            ]);

            return redirect()->route('account', ['tab' => 'orders'])
                ->with('error', "Payment was not completed for order #{$order->order_number}. Please try placing the order again.");
        }

        return redirect()->route('account', ['tab' => 'orders'])
            ->with('warning', "Payment for order #{$order->order_number} is pending confirmation from the bank. We will update your order status shortly.");
    }

    /**
     * Handle Server-to-Server Webhook Notifications from PhonePe.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $payload = $request->all();

        // If body is raw JSON or base64 encoded
        if (empty($payload) && $request->getContent()) {
            $raw = $request->getContent();
            $decoded = json_decode($raw, true);
            if ($decoded) {
                $payload = $decoded;
            } elseif ($request->has('response')) {
                $payload = json_decode(base64_decode($request->input('response')), true) ?? [];
            }
        }

        $processed = $this->phonePeService->processWebhook($payload);

        return response()->json([
            'status' => $processed ? 'SUCCESS' : 'FAILED',
            'message' => $processed ? 'Webhook processed successfully' : 'Webhook processing skipped or failed',
            'timestamp' => now()->toIso8601String(),
        ], 200);
    }
}
