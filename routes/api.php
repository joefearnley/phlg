<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;
use App\Http\Controllers\Api\ApplicationApiController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// })->name('api.user');

Route::group([
        'as' => 'api.',
        'middleware' => ['auth:sanctum']
    ], function() {
        Route::apiResource('applications', ApplicationApiController::class);
});
