<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $messages = Auth::user()->latestMessages();

        return view('dashboard', ['messages' => $messages]);
    }
}
