<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

// Route publik (tanpa login): daftar project dan detail project + gallery
Route::get('/projects', [PortfolioController::class, 'projects'])
    ->name('projects');

Route::get('/projects/{project}', [PortfolioController::class, 'show'])
    ->name('projects.show');

// Setelah login, Breeze mengarah ke route 'dashboard'.
// Admin diteruskan ke dashboard admin, user biasa melihat halaman dashboard sederhana.
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('post.dashboard.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/post/profile-saya', function () {
        return view('projects.profile-saya');
    })->name('post.profile-saya');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Grup admin: URL diawali /post, nama route diawali post.
    Route::prefix('post')->name('post.')->middleware('admin')->group(function () {
        // GET /post/dashboard -> post.dashboard.index
        Route::resource('dashboard', DashboardController::class)->only(['index']);

        // CRUD project (show tidak dipakai, detail publik ada di /projects/{project})
        Route::resource('projects', ProjectController::class)->except(['show']);

        // Gallery project: upload banyak gambar, edit caption, hapus gambar
        Route::post('projects/{project}/images', [ProjectGalleryController::class, 'store'])
            ->name('projects.images.store');
        Route::put('projects/{project}/images/{image}', [ProjectGalleryController::class, 'update'])
            ->name('projects.images.update');
        Route::delete('projects/{project}/images/{image}', [ProjectGalleryController::class, 'destroy'])
            ->name('projects.images.destroy');

        // Latihan mandiri: edit skill (index, edit, update)
        Route::resource('skills', SkillController::class)->only(['index', 'edit', 'update']);
    });
});

require __DIR__.'/auth.php';
