<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Application;

class DeleteApplication extends Component
{    
    /**
     * Whether or not to show modal.
     *
     * @var Boolean
     */
    public $confirmingDeletion;

    /**
     * Application model object being deleted.
     *
     * @var \App\Models\Application
     */
    public $application;

    /**
     * Mount the component.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function mount(Application $application)
    {
        $this->application = $application;
        $this->confirmingDeletion = false;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.delete-application');
    }

    /**
     * Delete the application and redirect to application index page.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        $this->application->messages()->delete();
        $this->application->delete();

        $this->confirmingDeletion = false;

        return redirect()->route('applications.index')
            ->with('message_type', 'success')
            ->with('message', 'Application has been deleted!');
    }
}
