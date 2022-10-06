<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageRequest;

class MessageApiController extends Controller
{
    /**
     * Store a newly created message in storage.
     *
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMessageRequest $request)
    {
        $application = Application::findOrFaile($request->application_id);
        $messageLevel = MessageLevel::findOrFail($request->level_id);

        $message = Message::create([
            'application_id' => $application->id,
            'level_id' => $messageLevel->id,
            'body' => $request->body
        ]);

        return response()->toJson([
            'success' => true,
            'message' => $message
        ]);
    }
}
