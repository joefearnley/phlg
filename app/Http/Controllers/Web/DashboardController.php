<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Get the main dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $messages = Auth::user()->latestMessages(10)->get();

        return view('dashboard', ['messages' => $messages]);
    }
}
