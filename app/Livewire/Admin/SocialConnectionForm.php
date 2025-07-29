<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SocialConnection;

class SocialConnectionForm extends Component
{
    public $social;

    public $facebook;
    public $twitter;
    public $pinterest;
    public $tiktok;
    public $instagram;
    public $youtube;

    public function mount()
    {
        $this->social = SocialConnection::first() ?? new SocialConnection();

        $this->facebook = $this->social->facebook;
        $this->twitter = $this->social->twitter;
        $this->pinterest = $this->social->pinterest;
        $this->tiktok = $this->social->tiktok;
        $this->instagram = $this->social->instagram;
        $this->youtube = $this->social->youtube;
    }

    public function save()
    {
        $this->social->updateOrCreate(
            ['id' => $this->social->id],
            [
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'pinterest' => $this->pinterest,
                'tiktok' => $this->tiktok,
                'instagram' => $this->instagram,
                'youtube' => $this->youtube,
            ]
        );

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Social links updated successfully!',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.social-connection-form');
    }
}
