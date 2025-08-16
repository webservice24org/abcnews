<?php

namespace App\Livewire\Admin\Pages;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;

class PageList extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['pageDeleted' => '$refresh'];

    public function deletePage($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        $this->dispatch('pageDeleted');
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Page deleted successfully!',
        ]);
    }

    public function toggleStatus($id)
    {
        $page = Page::findOrFail($id);

        $page->status = $page->status === 'published' ? 'draft' : 'published';
        $page->save();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "Page status changed to {$page->status}!",
        ]);
    }

    public function render()
    {
        $pages = Page::where('title', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.pages.page-list', compact('pages'));
    }
}

