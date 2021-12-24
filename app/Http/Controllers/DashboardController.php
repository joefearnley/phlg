<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $messages = Auth::user()->latestMessages(10)->get();

        return view('dashboard', ['messages' => $messages]);
    }
}
