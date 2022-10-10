<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeleteApplicationConfirmationModal extends Component
{
    public $confirmingApplicationDeletion;

    public function mount()
    {
        $this->confirmingApplicationDeletion = false;
    }

    public function render()
    {
        return view('livewire.delete-application-confirmation-modal');
    }

    public function confirmDeleteApplication()
    {
        dd('asklfjasldfas');

        $this->confirmingApplicationDeletion = true;
    }

    public function delete($application)
    {
        $application->messages()->delete();

        $application->delete();

        $this->confirmingApplicationDeletion = false;
    }
}
