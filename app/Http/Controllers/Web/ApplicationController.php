<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;

class ApplicationController extends Controller
{
    /**
     * Main applications page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $applications = $request->user()->applications;

        return view('applications.index', ['applications' => $applications]);
    }

    /**
     * Show the form for creating a new application.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('applications.create');
    }

    /**
     * Store a newly created application in storage.
     *
     * @param  \App\Http\Requests\StoreApplicationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreApplicationRequest $request)
    {
        $application = new Application(['name' => $request->name]);

        $application = $request->user()->createApplication($application);

        return redirect(route('applications.index'))
            ->with('message_type', 'success')
            ->with('message', 'Application - ' . $application->name . ' - has been created!');
    }

    /**
     * Show the form for editing the specified application.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\View\View
     */
    public function edit(Application $application)
    {
        $this->authorize('edit', $application);

        return view('applications.edit', ['application' => $application]);
    }

    /**
     * Update the specified application in storage.
     *
     * @param  \App\Http\Requests\UpdateApplicationRequest  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $this->authorize('update', $application);

        $application->name = $request->name;
        $application->save();

        return redirect(route('applications.index'))
            ->with('message_type', 'success')
            ->with('message', '<strong>' . $application->name . '</strong> has been updated!');
    }

    /**
     * Remove the specified application from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);

        $application->messages()->delete();

        $application->delete();

        return redirect(route('applications.index'))
            ->with('message_type', 'success')
            ->with('message', 'Application has been deleted!');
    }
}
