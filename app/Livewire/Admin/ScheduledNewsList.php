<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NewsPost;
use App\Traits\HandlesNewsDeletion;

class ScheduledNewsList extends Component
{
    use WithPagination, HandlesNewsDeletion;

    protected $paginationTheme = 'tailwind';


   protected $listeners = ['deleteConfirmed'];

    public function render()
    {
        $scheduledNews = NewsPost::where('status', 'scheduled')
            ->orderBy('scheduled_at', 'asc')
            ->paginate(10);

        return view('livewire.admin.scheduled-news-list', [
            'scheduledNews' => $scheduledNews,
        ]);
    }
}

