<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use Orion\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserApplicationsController extends Controller
{
    /**
     * Fully-qualified model class name
     */
    protected $model = User::class;

    protected $relation = 'applications';

    /**
     * Retrieves currently authenticated user based on the guard.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }
}
