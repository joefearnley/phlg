<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WelcomeController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\ApplicationController;
use App\Http\Controllers\Web\MessageController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('applications', ApplicationController::class);
    Route::resource('messages', MessageController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::post('/account/update-password', [AccountController::class, 'updatePassword'])->name('account.update-password');

    Route::get('/account/access-tokens', [AccountController::class, 'showAccessTokens'])->name('account.access-tokens');
    Route::post('/account/create-access-token', [AccountController::class, 'createAccessToken'])->name('account.create-access-token');
});

require __DIR__.'/auth.php';
