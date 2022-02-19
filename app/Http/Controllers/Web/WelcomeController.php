<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Main welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request  $request)
    {
        return view('welcome');
    }
}
