<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\CustomerOrderController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;

// === CUSTOMER ROUTES ===

// Homepage: Show welcome page instead of menu
Route::get('/', function () {
    return view('customer.welcome');
})->name('customer.welcome');

// QR Code for menu
Route::get('/admin/qr-code', function () {
    return view('admin.qr');
})->middleware('web'); // or 'auth' if you want only logged-in admin to view
Route::get('/index', [CustomerMenuController::class, 'index'])->name('customer.index');

// View actual menu
Route::get('/menu', [CustomerMenuController::class, 'menu'])->name('customer.menu');

// Cart
Route::get('/cart', [CustomerMenuController::class, 'viewCart'])->name('customer.cart');
Route::post('/cart/add', [CustomerMenuController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CustomerMenuController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CustomerMenuController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CustomerMenuController::class, 'clearCart'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CustomerOrderController::class, 'showCheckoutForm'])->name('cart.checkout');
Route::post('/checkout', [CustomerOrderController::class, 'store'])->name('order.store');

// Order Confirmation
Route::get('/thank-you/{order}', function ($orderId) {
    $order = \App\Models\Order::with('items.menuItem')->findOrFail($orderId);
    return view('customer.thank-you', compact('order'));
})->name('customer.thank-you');

// Order History
Route::get('/history', [CustomerOrderController::class, 'history'])->name('customer.history');

// === ADMIN AUTH ===
Route::get('/admin/login', fn() => view('admin.login'))->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', function () {
    session()->forget('admin_id');
    return redirect()->route('admin.login')->with('status', 'Logged out successfully.');
})->name('admin.logout');

// === ADMIN DASHBOARD & MODULES ===
Route::middleware('web')->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Menu Management
    Route::get('/admin/menu', [AdminMenuController::class, 'index'])->name('admin.menu');
    Route::post('/admin/menu/reorder', [AdminMenuController::class, 'reorder'])->name('admin.menu.reorder');
    Route::get('/admin/menu/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/admin/menu', [AdminMenuController::class, 'store'])->name('admin.menu.store');
    Route::post('/admin/menu/toggle-availability/{id}', [AdminMenuController::class, 'toggleAvailability'])->name('admin.menu.toggleAvailability');
    Route::get('/admin/menu/{id}/edit', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/admin/menu/{id}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/admin/menu/{id}', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');

    // Order Management
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::put('/admin/orders/{id}/update', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

});

// === USER DASHBOARD & SETTINGS (Breeze/Volt) ===
Route::view('/home', 'home');
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('/settings', '/settings/profile');
    Route::get('/settings/profile', Profile::class)->name('settings.profile');
    Route::get('/settings/password', Password::class)->name('settings.password');
    Route::get('/settings/appearance', Appearance::class)->name('settings.appearance');
});

// Laravel Breeze Auth
require __DIR__ . '/auth.php';

