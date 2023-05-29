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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMessageRequest $request)
    {
        $application = Application::find($request->application_id);

        if (is_null($application)) {
            return response()->json([
                'success' => false,
                'message' => 'Application Inactive.',
            ],  401);
        }

        $message = Message::create([
            'application_id' => $request->application_id,
            'level_id' => $request->level_id,
            'body' => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
