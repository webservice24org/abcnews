<?php

namespace App\Livewire\Frontend;

use App\Models\NewsPost;
use Livewire\Component;

class HomePage extends Component
{
     public function render()
    {
        $news = NewsPost::where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('livewire.frontend.home-page', compact('news'))
            ->layout('layouts.frontend')
            ->title('Home');
    }
}

