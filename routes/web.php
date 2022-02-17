<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\ApplicationController;
use App\Http\Controllers\Web\MessageController;

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

Route::resource('applications', ApplicationController::class)
    ->middleware(['auth']);

Route::resource('messages', MessageController::class)
    ->middleware(['auth']);

Route::resource('messages/search/{term}', [MessageController::class, 'search'])
    ->middleware(['auth'])
    ->name('message.search');

require __DIR__.'/auth.php';
