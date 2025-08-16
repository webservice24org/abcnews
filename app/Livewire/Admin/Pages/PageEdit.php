<?php

namespace App\Livewire\Admin\Pages;

use Livewire\Component;
use App\Models\Page;

class PageEdit extends Component
{
     public $pageId;
    public $title;
    public $description;
    public $layout_type = 'no-sidebar'; // default

    public function mount($id)
    {
        $page = Page::findOrFail($id);

        $this->pageId = $page->id;
        $this->title = $page->title;
        $this->description = $page->description;
        $this->layout_type = $page->layout_type; // load saved value
    }

    public function update()
    {
        $page = Page::findOrFail($this->pageId);

        $page->update([
            'title' => $this->title,
            'description' => $this->description,
            'layout_type' => $this->layout_type,
        ]);

        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => $this->pageId ? 'Page updated successfully!' : 'Content saved successfully!',
        ]);

    }

    public function render()
    {
        return view('livewire.admin.pages.page-edit');
    }
}

