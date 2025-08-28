<?php
namespace App\Livewire\Frontend;

use App\Models\News\Post;
use App\Models\HomepageSection; // 👈 the model we created earlier
use Livewire\Component;
 use App\Models\HomepageLeadSection;
class HomePage extends Component
{
   

    public function render()
    {
        $leadSettings = HomepageLeadSection::first();

        $leadNews = Post::where('status', 'published')
            ->where('is_lead', true)
            ->latest()
            ->first();

        $subLeadNews = Post::where('status', 'published')
            ->where('is_sub_lead', true)
            ->latest()
            ->take(5)
            ->get();

        $sections = HomepageSection::with('category')
            ->where('status', true)
            ->orderBy('order')
            ->get();

        return view('livewire.frontend.home-page', compact(
            'leadNews',
            'subLeadNews',
            'sections',
            'leadSettings'
        ))->layout('layouts.frontend')->title('Home');
    }

}
