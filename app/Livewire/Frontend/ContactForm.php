<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\Contact;

class ContactForm extends Component
{
    public $name, $email, $phone, $subject, $message;

    protected $rules = [
        'name'    => 'required|string|max:100',
        'email'   => 'required|email|max:150',
        'phone'   => 'nullable|string|max:16',
        'subject' => 'required|string|max:200',
        'message' => 'required|string|max:1000',
    ];

    public function submit()
    {
        $this->validate();

        Contact::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        // Reset form
        $this->reset(['name', 'email', 'phone', 'subject', 'message']);

        // Show toast or flash
        session()->flash('success', 'Your message has been sent successfully!');
       
    }

    public function render()
    {
        return view('livewire.frontend.contact-form')->layout('layouts.frontend');
    }
}
