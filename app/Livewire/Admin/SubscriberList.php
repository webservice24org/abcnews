<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Mail\SubscriberStatusMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SubscriberList extends Component
{
    public $subscribers;

    public function mount()
    {
        $this->loadSubscribers();
    }

    public function loadSubscribers()
    {
        $this->subscribers = Subscriber::latest()->get();
    }

    
    public function toggleStatus($id)
    {
        $subscriber = Subscriber::findOrFail($id);

        // Toggle status
        $subscriber->status = $subscriber->status === 'active' ? 'inactive' : 'active';
        $subscriber->save();

        // Send status email
        $customMessage = $subscriber->status === 'active' 
            ? 'Your subscription has been activated. You will now receive updates from us.'
            : 'Your subscription has been deactivated. You will no longer receive updates.';

        Mail::to($subscriber->email)->send(new SubscriberStatusMail(
            $subscriber, 
            $subscriber->status, 
            $customMessage
        ));

        $this->loadSubscribers();
        // Toast notification
        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Subscriber status updated successfully!',
        ]);
    }
    
    public function deleteSubscriber($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        $this->loadSubscribers();
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Subscriber deleted successfully!'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.subscriber-list');
    }
}

