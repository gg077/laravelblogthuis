<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ✅ Frontend Homepagina
Route::get('/', function () {
    return view('frontend.home');
});

// ✅ Backend routes (moet ingelogd zijn)
Route::middleware(['auth', 'verified'])->prefix('backend')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('backend.index');
    })->name('backend.index');

    // Gebruikersbeheer
    Route::resource('/users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy'
    ]);

    // Profielbeheer
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Laravel Auth routes
require __DIR__.'/auth.php';
