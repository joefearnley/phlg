<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\ApplicationController;

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

Route::get('/applications', [ApplicationController::class, 'index'])
    ->middleware(['auth'])
    ->name('applications');

require __DIR__.'/auth.php';
