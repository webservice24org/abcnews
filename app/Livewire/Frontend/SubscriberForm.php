<?php

namespace App\Livewire\Frontend;


use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriberStatusMail;

use Illuminate\Support\Facades\URL;

class SubscriberForm extends Component
{
    public $name;
    public $email;

    public function subscribe()
    {
        $this->validate([
            'name'  => 'required|string|min:3',
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $subscriber = Subscriber::create([
            'name'      => $this->name,
            'email'     => $this->email,
            'status'    => 'inactive',
            'is_agree'  => 1, 
        ]);

        Mail::to($subscriber->email)->send(new SubscriberStatusMail(
            $subscriber,
            'inactive',
            'Thank you for subscribing! Your subscription has been received. After review, we will activate it and notify you.'
        ));

        $this->reset();

        session()->flash('success', 'Your subscription is received! We will notify you once it is active!');
    }

    


    public function render()
    {
        return view('livewire.frontend.subscriber-form');
    }
}
