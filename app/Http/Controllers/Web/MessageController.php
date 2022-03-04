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
    public function index(Request $request)
    {
        $appId = $request->has('appid') ? $request->query('appid') : null;
        $searchTerm = $request->has('term') ? $request->query('term') : null;

        $messages = Auth::user()->searchMessages($searchTerm, $appId)->get();

        $selectedApplication = $appId ? Application::find($appId) : null;

        $applications = Auth::user()->applications;

        return view('messages.index', [
            'messages' => $messages,
            'applications' => $applications,
            'selectedApplication' => $selectedApplication,
        ]);
    }

    /**
     * Messages search page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param String  $term
     * @return \Illuminate\View\View
     */
    public function search($term)
    {
        $messages = Auth::user()->searchMessages($term)->get();

        return view('messages.search-results', [
            'messages' => $messages,
            'searchTerm' => $term,
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
