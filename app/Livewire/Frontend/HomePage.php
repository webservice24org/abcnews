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

        $leadNews = NewsPost::where('status', 'published')
        ->where('is_lead', true)
        ->latest()
        ->first();

        $subLeadNews = NewsPost::where('status', 'published')
        ->where('is_sub_lead', true)
        ->latest()
        ->take(5)
        ->get();




        return view('livewire.frontend.home-page', compact('news', 'leadNews', 'subLeadNews'))
            ->layout('layouts.frontend')
            ->title('Home');
    }
}

