<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactReply extends Component
{
    public $contact;
    public $reply;

    public function mount(Contact $contact)
    {
        $this->contact = $contact;
        $this->reply = $contact->reply;
    }

    public function sendReply()
    {
        $this->validate([
            'reply' => 'required|string|min:5',
        ]);

        // Send mail
        Mail::raw($this->reply, function ($message) {
            $message->to($this->contact->email)
                ->subject("Reply: {$this->contact->subject}");
        });

        // Update DB properly
        $this->contact->reply = $this->reply;
        $this->contact->status = 'replied';
        $this->contact->save();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Reply sent successfully!'
        ]);
        return redirect()->route('contacts.index');
    }


    public function render()
    {
        return view('livewire.admin.contact-reply');
    }
}