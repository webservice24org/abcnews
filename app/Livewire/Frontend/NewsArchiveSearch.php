<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class NewsArchiveSearch extends Component
{
    public $selectedDate;

    public function redirectToArchive()
    {
        if ($this->selectedDate) {
            return redirect()->route('archive.show', ['date' => $this->selectedDate]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.news-archive-search');
    }
}
