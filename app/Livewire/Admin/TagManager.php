<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tag;

class TagManager extends Component
{
    use WithPagination;

    public $name;
    public $editingTagId = null;
    public $editingName;

    protected $rules = [
        'name' => 'required|string|max:255|unique:tags,name',
    ];

    protected $listeners = ['deleteConfirmed'];

    public function saveTag()
    {
        $this->validate();

        Tag::create(['name' => $this->name]);

        $this->reset('name');

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Tag added successfully.']);
    }

    public function editTag($id)
    {
        $tag = Tag::findOrFail($id);
        $this->editingTagId = $tag->id;
        $this->editingName = $tag->name;
    }

    public function updateTag()
    {
        $this->validate([
            'editingName' => 'required|string|max:255|unique:tags,name,' . $this->editingTagId,
        ]);

        $tag = Tag::findOrFail($this->editingTagId);
        $tag->update(['name' => $this->editingName]);

        $this->reset('editingTagId', 'editingName');

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Tag updated successfully.']);
    }

    public function confirmDeleteTag($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function deleteConfirmed($id)
    {
        Tag::findOrFail($id)->delete();

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Tag deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.tag-manager', [
            'tags' => Tag::latest()->paginate(10),
        ]);
    }
}
