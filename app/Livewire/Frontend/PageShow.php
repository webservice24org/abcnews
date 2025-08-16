<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Page;

class PageShow extends Component
{
    public $slug;
    public $page;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->page = Page::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        if ($this->page->layout_type === 'right-sidebar') {
            return view('livewire.frontend.page-show-with-sidebar')
                ->layout('layouts.frontend');
        }

        return view('livewire.frontend.page-show')
            ->layout('layouts.frontend');
    }
}
