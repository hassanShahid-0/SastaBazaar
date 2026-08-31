<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController as PublicShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Citizen\AuthController as CitizenAuthController;
use App\Http\Controllers\Citizen\OrderController as CitizenOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CommodityController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\CitizenController as AdminCitizenController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\ShopListingController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/complaint', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/complaint', [ComplaintController::class, 'store'])->middleware('throttle:5,1')->name('complaint.store');
Route::get('/dashboard', function () {
    if (auth()->user()?->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ── Admin Routes (protected by auth + IsAdmin middleware) ──
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('commodities', CommodityController::class);
    Route::get('prices', [PriceController::class, 'index'])->name('prices.index');
    Route::post('prices', [PriceController::class, 'store'])->name('prices.store');

    // Complaints management
    Route::get('complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('complaints/{complaint}/toggle', [AdminComplaintController::class, 'toggleStatus'])->name('complaints.toggle');
    Route::delete('complaints/{complaint}', [AdminComplaintController::class, 'destroy'])->name('complaints.destroy');

    // ── Citizen Management ──
    Route::get('citizens', [AdminCitizenController::class, 'index'])->name('citizens.index');
    Route::patch('citizens/{citizen}/toggle-block', [AdminCitizenController::class, 'toggleBlock'])->name('citizens.toggleBlock');

    // ── Shop Management ──
    Route::resource('shops', AdminShopController::class);
    Route::patch('shops/{shop}/verify', [AdminShopController::class, 'verify'])->name('shops.verify');

    // ── Shop Listings ──
    Route::get('shops/{shop}/listings', [ShopListingController::class, 'index'])->name('shops.listings.index');
    Route::post('shops/{shop}/listings', [ShopListingController::class, 'store'])->name('shops.listings.store');
    Route::delete('shops/{shop}/listings/{listing}', [ShopListingController::class, 'destroy'])->name('shops.listings.destroy');

    // ── Order Management ──
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// ── Citizen Auth Routes ──
Route::prefix('citizen')->name('citizen.')->group(function () {
    // Guest-only
    Route::middleware('guest:citizen')->group(function () {
        Route::get('register', [CitizenAuthController::class, 'registerForm'])->name('register');
        Route::post('register', [CitizenAuthController::class, 'register'])->name('register.store');
        Route::get('login', [CitizenAuthController::class, 'loginForm'])->name('login');
        Route::post('login', [CitizenAuthController::class, 'login'])->name('login.store');
    });

    // Authenticated citizens only
    Route::middleware(['citizen.auth', 'citizen.notblocked'])->group(function () {
        Route::post('logout', [CitizenAuthController::class, 'logout'])->name('logout');
        Route::get('orders', [CitizenOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [CitizenOrderController::class, 'show'])->name('orders.show');
    });
});

// ── Public Marketplace Routes ──
Route::prefix('marketplace')->name('marketplace.')->group(function () {
    Route::get('/', [PublicShopController::class, 'index'])->name('index');
    Route::get('/shops/{shop}', [PublicShopController::class, 'show'])->name('shops.show');
});

// ── Cart Routes (citizen auth required for modifying) ──
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::middleware(['citizen.auth', 'citizen.notblocked'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{commodityId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{commodityId}', [CartController::class, 'remove'])->name('cart.remove');
});

// ── Checkout Routes (citizen auth required) ──
Route::middleware(['citizen.auth', 'citizen.notblocked'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/address', [CheckoutController::class, 'address'])->name('address');
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('placeOrder');
    Route::get('/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('confirmation');
});