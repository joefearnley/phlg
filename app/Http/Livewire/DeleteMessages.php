<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeleteMessages extends Component
{
    /**
    * Whether or not to show modal.
    *
    * @var Boolean
    */
   public $confirmingDeletion;

    /**
    * Mount the component and set defaults.
    *
    * @return void
    */
    public function mount()
    {
        $this->confirmingDeletion = false;
    }

    /**
     * Render the delete messages miodal component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.delete-messages');
    }

    /**
     * Delete all messages and redirect to message index page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        auth()->user()->messages->each(function($message){
            $message->delete();
         });

        $this->confirmingDeletion = false;

        return redirect()->route('messages.index')
            ->with('message_type', 'success')
            ->with('message', 'All messages have been deleted!');
    }
}
