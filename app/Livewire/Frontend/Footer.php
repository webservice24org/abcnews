<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Page;
class Footer extends Component
{
    public $pages;

    public function mount()
    {
        // Only published pages
        $this->pages = Page::where('status', 'published')
            ->orderBy('title')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.footer');
    }
}