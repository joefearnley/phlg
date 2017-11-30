<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageApiController extends Controller
{

    public function index()
    {
        return response()->json(Message::all());
    }

    public function show($id)
    {
        $message = Message::find($id);

        return response()->json($message);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'level' => 'required'
        ]);

        $message = Message::create($request->all());

        return response()->json($message);
    }

    public function update(Request $request)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
