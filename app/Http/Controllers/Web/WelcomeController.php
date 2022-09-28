<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

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
