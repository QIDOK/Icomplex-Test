<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('album');
Route::post('/album/store', [AlbumController::class, 'store'])->middleware(['auth', 'verified'])->name('album.store');
Route::get('/view/{id}', [AlbumController::class, 'view'])->name('album.view');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/{login}', [ProfileController::class, 'index']);
