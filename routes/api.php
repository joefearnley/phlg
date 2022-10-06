<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageApiController;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/messages', [MessageApiController::class, 'store'])
        ->name('api.messages.store');
});
