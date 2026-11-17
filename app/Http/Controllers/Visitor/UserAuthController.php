<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'contactNo' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'An account with this email address already exists.',
            'contactNo.required' => 'Please enter your contact phone number.',
            'password.required' => 'Please enter a secure password.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        // Create new customer user (role defaults to 'User')
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contactNo' => $request->contactNo,
            'password' => $request->password,
            'role' => 'User',
        ]);

        // Auto-login the newly registered user
        Auth::login($user, true);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        // Merge guest cart if present
        $guestCart = $request->input('guest_cart', $request->input('cart', []));
        if (is_array($guestCart) && !empty($guestCart)) {
            CartController::mergeGuestCartItems($user, $guestCart);
        }

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'contactNo' => $user->contactNo,
            'role' => $user->role,
            'is_admin' => $user->isAdmin(),
        ];

        $userCart = $user->cartItems()->latest()->get()->map(fn($item) => [
            'id' => $item->product_id ?: $item->id,
            'db_id' => $item->id,
            'name' => $item->product_name,
            'price' => (float) $item->price,
            'image' => $item->image ?: asset('image/products/product-1.jpg'),
            'qty' => (int) $item->qty,
        ])->toArray();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Welcome to Yuvar Dhan, ' . $user->name . '! Your account is now active.',
                'user' => $userData,
                'cart' => $userCart,
            ], 201);
        }

        return redirect()
            ->intended(route('home'))
            ->with('success', 'Welcome to Yuvar Dhan, ' . $user->name . '! Your account is now active.');
    }

    /**
     * Handle user login via Email or Phone Number (contactNo).
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $loginInput = $request->input('login', $request->input('email', ''));

        $validator = Validator::make([
            'login' => $loginInput,
            'password' => $request->password,
        ], [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Please enter your registered email address or contact number.',
            'password.required' => 'Please enter your password.',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput($request->only('login', 'email', 'remember'));
        }

        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'contactNo';
        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }

            $user = Auth::user();

            // Merge guest cart if present
            $guestCart = $request->input('guest_cart', $request->input('cart', []));
            if (is_array($guestCart) && !empty($guestCart)) {
                CartController::mergeGuestCartItems($user, $guestCart);
            }

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contactNo' => $user->contactNo,
                'role' => $user->role,
                'is_admin' => $user->isAdmin(),
            ];

            $userCart = $user->cartItems()->latest()->get()->map(fn($item) => [
                'id' => $item->product_id ?: $item->id,
                'db_id' => $item->id,
                'name' => $item->product_name,
                'price' => (float) $item->price,
                'image' => $item->image ?: asset('image/products/product-1.jpg'),
                'qty' => (int) $item->qty,
            ])->toArray();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Welcome back, ' . $user->name . '!',
                    'user' => $userData,
                    'cart' => $userCart,
                ]);
            }

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // Authentication failed
        $errorMessage = 'Invalid credentials. Please verify your email/phone and password.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'errors' => [
                    'login' => [$errorMessage],
                ],
            ], 422);
        }

        return back()
            ->withInput($request->only('login', 'email', 'remember'))
            ->withErrors(['login' => $errorMessage]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        Auth::logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'You have been signed out successfully.',
            ]);
        }

        return redirect()
            ->route('home')
            ->with('success', 'You have been signed out successfully.');
    }

    /**
     * Get current authenticated user details.
     */
    public function me(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'authenticated' => false,
                'user' => null,
            ]);
        }

        $user = Auth::user();
        $userCart = $user->cartItems()->latest()->get()->map(fn($item) => [
            'id' => $item->product_id ?: $item->id,
            'db_id' => $item->id,
            'name' => $item->product_name,
            'price' => (float) $item->price,
            'image' => $item->image ?: asset('image/products/product-1.jpg'),
            'qty' => (int) $item->qty,
        ])->toArray();

        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contactNo' => $user->contactNo,
                'role' => $user->role,
                'is_admin' => $user->isAdmin(),
            ],
            'cart' => $userCart,
        ]);
    }

    /**
     * Update customer profile details.
     */
    public function updateProfile(Request $request): JsonResponse|RedirectResponse
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please sign in to update your profile.',
                ], 401);
            }
            return redirect()->route('account')->with('error', 'Please sign in to update your profile.');
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'contactNo' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'contactNo' => $request->contactNo,
        ];

        if ($request->filled('password')) {
            $userData['password'] = $request->password;
        }

        $user->update($userData);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your profile has been updated successfully!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'contactNo' => $user->contactNo,
                    'role' => $user->role,
                    'is_admin' => $user->isAdmin(),
                ],
            ]);
        }

        return redirect()->route('account')->with('success', 'Your profile has been updated successfully!');
    }
}
