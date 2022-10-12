<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Application;

class DeleteApplication extends Component
{
    public $confirmingDeletion;
    public $application;

    public function mount(Application $application)
    {
        $this->application = $application;
    }

    public function render()
    {
        return view('livewire.delete-application');
    }

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
