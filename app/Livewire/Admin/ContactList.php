<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactList extends Component
{
    use WithPagination;

    public $replyContactId;
    public $replyMessage = '';
    public $search = '';

    protected $listeners = ['contactDeleted' => '$refresh'];

    public function deleteContact($id)
    {
        Contact::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Contact deleted successfully!');

    }

    public function showReplyModal($id)
    {
        $this->replyContactId = $id;
        $this->replyMessage = Contact::findOrFail($id)->reply ?? '';
        $this->dispatch('showReplyModal'); // open modal via JS
    }

    

    public function render()
    {
        $contacts = Contact::where('name','like',"%{$this->search}%")
            ->orWhere('email','like',"%{$this->search}%")
            ->orWhere('subject','like',"%{$this->search}%")
            ->orderBy('id','desc')
            ->paginate(10);

        return view('livewire.admin.contact-list', compact('contacts'));
    }
}