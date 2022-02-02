<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Controllers\Controller;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Main applications page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $applications = Auth::user()->applications;

        return view('applications.index', ['applications' => $applications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('applications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreApplicationRequest $request)
    {
        $application = new Application(['name' => $request->name]);

        $application = Auth::user()->createApplication($application);

        return redirect(route('applications.index'))
            ->with('message_type', 'success')
            ->with('message', 'Application - ' . $application->name . ' - has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        $this->authorize('edit', $application);

        return view('applications.edit', ['application' => $application]);
    }

    /**
     * Update the specified resource in storage.
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
            ->with('message', 'Application - ' . $application->name . ' - has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
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
