<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(auth()->check() ? 'assets.index' : 'login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    Route::post('/assets/sync', [AssetController::class, 'sync'])->name('assets.sync');
    Route::get('/assets/{asset}', [AssetController::class, 'show'])->name('assets.show');
    Route::resource('alerts', AlertController::class)->except('show');
});
