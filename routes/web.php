<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\ItemProyekController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('proyek', ProyekController::class)->middleware('auth');

    Route::prefix('proyek/{proyek}/item')->name('proyek.item.')->group(function () {
        Route::get('/create', [ItemProyekController::class, 'create'])->name('create');
        Route::post('/', [ItemProyekController::class, 'store'])->name('store');
        Route::get('/{itemProyek}/upload', [ItemProyekController::class, 'upload'])->name('upload');
        Route::post('/{itemProyek}/upload', [ItemProyekController::class, 'storeFoto'])->name('upload.store');
        Route::delete('/{itemProyek}/foto/{foto}', [ItemProyekController::class, 'destroyFoto'])->name('foto.destroy');
        Route::delete('/{itemProyek}', [ItemProyekController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserManagementController::class)->except(['show']);
});

require __DIR__ . '/auth.php';
