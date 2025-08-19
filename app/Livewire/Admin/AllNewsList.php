<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\HandlesNewsDeletion;
use App\Models\News\Post;


class AllNewsList extends Component
{
    use WithPagination, HandlesNewsDeletion;

    protected $paginationTheme = 'tailwind';


   protected $listeners = ['deleteConfirmed'];

    

    public function render()
    {
        $newsPosts = Post::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.all-news-list', [
            'newsPosts' => $newsPosts,
        ]);
    }

    
}

