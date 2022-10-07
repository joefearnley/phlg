<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\MessageLevel;
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
        $application = Application::find($request->application_id);
        if (!$application) {
            return response()->json([
                'message' => 'Application not found.',
                'errors' => [
                    'application_id' => [
                        'The application id field is invalid.'
                    ]
                ]
            ], 404);
        }

        $messageLevel = MessageLevel::find($request->level_id);
        if (!$messageLevel) {
            return response()->json([
                'message' => 'Message Level not found.',
                'errors' => [
                    'level_id' => [
                        'The level id field is invalid.'
                    ]
                ]
            ], 404);
        }

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
