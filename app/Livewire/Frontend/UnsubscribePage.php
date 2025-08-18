<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Subscriber;

class UnsubscribePage extends Component
{
    public $subscriber;

    public function mount($email)
    {
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->update([
                'is_agree' => 0,
                'status'   => 'inactive',
            ]);

            $this->subscriber = $subscriber;
        }
    }

    public function render()
    {
        if ($this->subscriber) {
            return view('livewire.frontend.unsubscribe-page', [
                'subscriber' => $this->subscriber
            ])->layout('layouts.frontend');
        }

        return view('livewire.frontend.unsubscribe-notfound')
            ->layout('layouts.frontend');
    }
}
