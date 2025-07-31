<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\NewsPost;

class SearchResults extends Component
{
    public $query;

    public function mount()
    {
        $this->query = request('q', '');
    }

    public function render()
    {
        $results = [];

        if (strlen($this->query) > 1) {
            $results = NewsPost::where('status', 'published')
                ->where(function ($query) {
                    $query->where('news_title', 'like', '%' . $this->query . '%')
                        ->orWhere('news_description', 'like', '%' . $this->query . '%');
                })
                ->orderByRaw("
                    CASE 
                        WHEN news_title LIKE ? THEN 0 
                        ELSE 1 
                    END", ['%' . $this->query . '%'])
                ->latest()
                ->paginate(10);
        }

        return view('livewire.frontend.search-results', [
            'results' => $results,
        ])->layout('layouts.frontend')->title('সংবাদ অনুসন্ধান');
    }

}