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

        session()->flash('message', 'Page deleted successfully.');
        $this->dispatch('pageDeleted');
    }

    public function render()
    {
        $pages = Page::where('title', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.pages.page-list', compact('pages'));
    }
}