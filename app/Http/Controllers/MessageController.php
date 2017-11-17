<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Application;

class MessageController extends Controller
{
    /**
     * Display a listing of Messages
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        Message::first()->application;

        return view('messages')
            ->withMessages(Message::all())
            ->withApplications(Application::all());
    }

    /**
     * Display a listing of Messages for a specific application
     *
     * @return \Illuminate\View\View
     */
    public function application(Request $request)
    {
        $application = Application::find($request->id);

        return view('messages')
            ->withMessages($application->messages)
            ->withSelectedApplication($application)
            ->withApplications(Application::all());
    }
}
