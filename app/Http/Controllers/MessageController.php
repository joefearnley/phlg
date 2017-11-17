<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of Messages
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('messages')->withMessages(Message::all());
    }
}
