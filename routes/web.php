<?php

use App\Http\Controllers\DashboardController; // <-- 1. Tambahkan import ini
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/post/profile-saya', function () {
        return view('projects.profile-saya');
    })->name('post.profile-saya');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 2. Sesuaikan grup prefix 'post' dengan Langkah 3 di modul:
    Route::prefix('post')->name('post.')->middleware('admin')->group(function () {
        Route::resource('dashboard', DashboardController::class);
        Route::resource('projects', ProjectController::class);
    });
});

require __DIR__.'/auth.php';