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

        $nationalNews = Category::where('slug', 'national')->first()?->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();

        $internationalNews = Category::where('slug', 'international')->first()?->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();

       
        $economyNews = Category::where('slug', 'economics')->first()?->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get() ?? collect();


        $health = Category::where('slug', 'health')->first()?->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();

        

        return view('livewire.frontend.home-page', compact(
            'leadNews',
            'subLeadNews',
            'nationalNews',
            'internationalNews',
            'economyNews',
            'health',
            
        ))->layout('layouts.frontend')->title('Home');
    }
}
