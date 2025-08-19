<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\News\Post;
use App\Traits\HandlesNewsDeletion;

class DraftNewsList extends Component
{
     use WithPagination, HandlesNewsDeletion;

    protected $paginationTheme = 'tailwind';


   protected $listeners = ['deleteConfirmed'];

    public function render()
    {
        $draftNews = Post::where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.draft-news-list', [
            'draftNews' => $draftNews,
        ]);
    }
}