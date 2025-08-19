<?php

namespace App\Livewire\Frontend;

use App\Models\News\Post;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class NewsArchivePage extends Component
{
    use WithPagination;

    public $date;

    public function mount($date)
    {
        $this->date = $date;
    }

    public function render()
    {
        $parsedDate = Carbon::parse($this->date)->startOfDay();

        $newsList = Post::where('status', 'published')
            ->whereDate('created_at', $parsedDate)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.frontend.news-archive-page', [
            'newsList' => $newsList,
            'parsedDate' => $parsedDate,
        ])->layout('layouts.frontend')->title('সংবাদ আর্কাইভ');
    }
}

