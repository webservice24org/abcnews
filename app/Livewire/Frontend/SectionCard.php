<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class SectionCard extends Component
{
    public string $title;
    public $news;

    public function mount(string $title, $news)
    {
        $this->title = $title;
        $this->news = $news;
    }

    public function render()
    {
        return view('livewire.frontend.section-card');
    }
}
