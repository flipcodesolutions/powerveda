<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Visitor\AddressController;
use App\Http\Controllers\Visitor\CartController;
use App\Http\Controllers\Visitor\ContactController as VisitorContactController;
use App\Http\Controllers\Visitor\OrderController as VisitorOrderController;
use App\Http\Controllers\Visitor\PageController;
use App\Http\Controllers\Visitor\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Power Veda
|--------------------------------------------------------------------------
*/

// Visitor Frontend Routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/product/{product}', [PageController::class, 'productDetail'])->name('product.detail');
Route::get('/account', [PageController::class, 'account'])->name('account');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');

// Visitor Contact Form Submission
Route::post('/contact', [VisitorContactController::class, 'submit'])->name('contact.submit');

// Storefront User Authentication & Profile Routes (Visitor/Customer)
Route::post('/register', [UserAuthController::class, 'register'])->name('register');
Route::post('/login', [UserAuthController::class, 'login'])->name('login');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
Route::get('/user/me', [UserAuthController::class, 'me'])->name('user.me');
Route::post('/user/profile', [UserAuthController::class, 'updateProfile'])->name('user.profile');

// User Addresses Management Routes
Route::get('/user/addresses', [AddressController::class, 'index'])->name('user.addresses.index');
Route::post('/user/addresses', [AddressController::class, 'store'])->name('user.addresses.store');
Route::put('/user/addresses/{address}', [AddressController::class, 'update'])->name('user.addresses.update');
Route::delete('/user/addresses/{address}', [AddressController::class, 'destroy'])->name('user.addresses.destroy');
Route::post('/user/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('user.addresses.default');

// Cart Management Routes (Database Persistence for Logged-In Users & Syncing)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/sync', [CartController::class, 'sync'])->name('cart.sync');

// Customer Checkout & Order Placement Routes
Route::post('/checkout/place-order', [VisitorOrderController::class, 'store'])->name('checkout.place_order');
Route::get('/user/orders', [VisitorOrderController::class, 'index'])->name('user.orders.list');

// Friendly Redirects
Route::get('/orders', function () {
    return redirect()->route('account', ['tab' => 'orders']);
})->name('user.orders');
Route::redirect('/privacy', '/privacy-policy');
Route::redirect('/terms', '/terms-and-conditions');
Route::redirect('/refund', '/refund-policy');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Console Protected Routes (Admin Middleware)
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Standard Product CRUD Resource
    Route::resource('products', ProductController::class);

    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Reviews Management
    Route::resource('reviews', ReviewController::class);

    // Contact Inquiries Management
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.status');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});
