<?php

namespace App\Livewire\Frontend;

use App\Models\NewsPost;
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

        $newsList = NewsPost::where('status', 'published')
            ->whereDate('created_at', $parsedDate)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.frontend.news-archive-page', [
            'newsList' => $newsList,
            'parsedDate' => $parsedDate,
        ])->layout('layouts.frontend')->title('সংবাদ আর্কাইভ');
    }
}

