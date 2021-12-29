<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/account', [AccountController::class, 'index'])
    ->middleware(['auth'])
    ->name('account');

Route::post('/account/update', [AccountController::class, 'update'])
    ->middleware(['auth'])
    ->name('account.update');

Route::post('/account/update-password', [AccountController::class, 'updatePassword'])
    ->middleware(['auth'])
    ->name('account.update-password');

require __DIR__.'/auth.php';
