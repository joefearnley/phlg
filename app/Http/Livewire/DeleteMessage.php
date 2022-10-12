<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;

class DeleteMessage extends Component
{
    /**
    * Whether or not to show modal.
    *
    * @var Boolean
    */
   public $confirmingDeletion;

   /**
    * Message model object being deleted.
    *
    * @var \App\Models\Message
    */
   public $message;

   /**
    * Mount the component.
    *
    * @param  \App\Models\Message  $message
    * @return void
    */
   public function mount(Message $message)
   {
       $this->message = $message;
       $this->confirmingDeletion = false;
   }

    /**
     * Render the delete message component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.delete-message');
    }

    /**
     * Delete the message and redirect to message index page.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        $this->message->delete();

        $this->confirmingDeletion = false;

        return redirect()->route('messages.index')
            ->with('message_type', 'success')
            ->with('message', 'Message has been deleted!');
    }
}
