<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ApplicationApiController;

Route::group([
        'as' => 'api.',
        'middleware' => ['auth:sanctum']
    ], function() {
        Route::get('user', [UserApiController::class, 'index'])->name('user');
        Route::apiResource('applications', ApplicationApiController::class);
});
