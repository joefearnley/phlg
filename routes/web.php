<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WelcomeController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ApplicationController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('applications', ApplicationController::class);
    // Route::resource('messages', MessageController::class);
});
