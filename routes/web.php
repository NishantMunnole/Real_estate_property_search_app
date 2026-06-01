<?php

use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('properties.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('properties')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])->name('properties.index');
    Route::post('/insert', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/search', [PropertyController::class, 'search'])->name('properties.search');
    Route::post('/update', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::post('/generate-description', [PropertyController::class, 'generateDescription'])->name('properties.generateDescription');
});

Route::prefix('enquiry')->group(function () {
    Route::get('/', [EnquiryController::class, 'index'])->middleware('auth')->name('enquiry.index');
    Route::post('/insert', [EnquiryController::class, 'store'])->name('enquiry.store');
    Route::post('/update', [EnquiryController::class, 'update'])->name('enquiry.update');
    Route::delete('/{id}', [EnquiryController::class, 'destroy'])->name('enquiry.destroy');
});




require __DIR__ . '/auth.php';
