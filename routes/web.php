<?php

use App\Http\Controllers\Admin\BlockedDateController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/paket-wedding', [PackageController::class, 'index'])->name('packages.index');
Route::get('/paket-wedding/{package}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/api/booking-calendar', [BookingController::class, 'calendar'])->name('booking.calendar');
Route::post('/booking-survei', [BookingController::class, 'store'])->name('booking.store');

Route::redirect('/dashboard', '/admin')->middleware(['auth', 'admin'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('packages', AdminPackageController::class)->except('show');
    Route::resource('hero-slides', AdminHeroSlideController::class)->except('show');
    Route::resource('services', AdminServiceController::class)->except('show');

    Route::get('gallery', [AdminGalleryController::class, 'index'])->name('gallery.index');
    Route::get('gallery/create', [AdminGalleryController::class, 'create'])->name('gallery.create');
    Route::post('gallery', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::delete('gallery/{gallery}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    Route::post('blocked-dates', [BlockedDateController::class, 'store'])->name('blocked-dates.store');
    Route::delete('blocked-dates/{blockedDate}', [BlockedDateController::class, 'destroy'])->name('blocked-dates.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
