<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class SectionCard extends Component
{
    public string $title;
    public $news;
    public string $categorySlug = '';


    public function mount(string $title, $news, string $categorySlug = '')
    {
        $this->title = $title;
        $this->news = $news;
        $this->categorySlug = $categorySlug;
    }

    public function render()
    {
        return view('livewire.frontend.section-card');
    }
}
