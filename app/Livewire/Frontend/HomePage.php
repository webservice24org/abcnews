<?php
namespace App\Livewire\Frontend;

use App\Models\News\Post;
use App\Models\Category;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        

        $leadNews = Post::where('status', 'published')
            ->where('is_lead', true)
            ->latest()
            ->first();

        $subLeadNews = Post::where('status', 'published')
            ->where('is_sub_lead', true)
            ->latest()
            ->take(5)
            ->get();

    
        

        return view('livewire.frontend.home-page', compact(
            'leadNews',
            'subLeadNews',
            
        ))->layout('layouts.frontend')->title('Home');
    }
}
