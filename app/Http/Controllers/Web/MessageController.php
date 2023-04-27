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
        $appId = $request->query('appid');
        $searchTerm = $request->query('term');

        $selectedApplication = Application::find($appId);
        $messages = $request->user()->searchMessages($appId, $searchTerm)->paginate(20);

        $applications = $request->user()->applications;

        return view('messages.index', [
            'messages' => $messages,
            'applications' => $applications,
            'selectedApplication' => $selectedApplication,
            'searchTerm' => $searchTerm,
        ]);
    }

    /**
     * Messages search page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param String  $term
     * @return \Illuminate\View\View
     */
    public function search(Request  $request, $term)
    {
        $messages = $request->user()->searchMessages($term)->get();

        return view('messages.search-results', [
            'messages' => $messages,
            'searchTerm' => $term,
        ]);
    }
}
