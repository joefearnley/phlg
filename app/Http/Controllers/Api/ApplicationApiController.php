<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use Orion\Http\Controllers\Controller;

class ApplicationApiController extends Controller
{
    /**
     * Fully-qualified model class name
     */
    protected $model = Application::class;
}
