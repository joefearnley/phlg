<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Main messages page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request  $request)
    {
        $selectedApplication = null;

        if ($request->has('appid')) {
            $appId = $request->query('appid');
            $messages = Auth::user()->messages->where('application_id', $appId);
            $selectedApplication = Application::find($appId);
        } else {
            $messages = Auth::user()->messages;
        }

        $applications = Auth::user()->applications;

        return view('messages.index', [
            'messages' => $messages,
            'applications' => $applications,
            'selectedApplication' => $selectedApplication,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
