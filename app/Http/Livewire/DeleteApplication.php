<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Application;

class DeleteApplication extends Component
{
    public $confirmingDeletion;

    public function render()
    {
        return view('livewire.delete-application');
    }

    public function delete(Application $application)
    {

        dd($application);


        // $application->messages()->delete();

        // $application->delete();

        // $this->confirmingApplicationDeletion = false;
    }
}
