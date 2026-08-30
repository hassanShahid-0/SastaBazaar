<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CommodityController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
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
});