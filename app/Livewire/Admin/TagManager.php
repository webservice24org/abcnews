<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tag;

class TagManager extends Component
{
    use WithPagination;
    protected $listeners = ['deleteConfirmed'];

    public $name;
    public $slug;

    public $editingTagId = null;
    public $editingName;
    public $editingSlug;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:tags,name,' . ($this->editingTagId ?? 'NULL'),
            'slug' => 'nullable|string|max:255|unique:tags,slug,' . ($this->editingTagId ?? 'NULL'),
        ];
    }

    public function saveTag()
    {
        $this->validate();

        Tag::create([
            'name' => $this->name,
            'slug' => $this->slug ? \Str::slug($this->slug) : \Str::slug($this->name),
        ]);

        $this->reset('name', 'slug');

        $this->dispatch('toast', type: 'success', message: 'Tag added successfully.');  
    }

    public function editTag($id)
    {
        $tag = Tag::findOrFail($id);
        $this->editingTagId = $tag->id;
        $this->editingName = $tag->name;
        $this->editingSlug = $tag->slug;
    }

    public function updateTag()
    {
        $this->validate([
            'editingName' => 'required|string|max:255|unique:tags,name,' . $this->editingTagId,
            'editingSlug' => 'nullable|string|max:255|unique:tags,slug,' . $this->editingTagId,
        ]);

        $tag = Tag::findOrFail($this->editingTagId);
        $tag->update([
            'name' => $this->editingName,
            'slug' => $this->editingSlug ? \Str::slug($this->editingSlug) : \Str::slug($this->editingName),
        ]);

        $this->reset('editingTagId', 'editingName', 'editingSlug');

        $this->dispatch('toast', type: 'success', message: 'Tag updated successfully.');
    }

    public function confirmDeleteTag($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function deleteConfirmed($id)
    {
        Tag::findOrFail($id)->delete();

        $this->dispatch('toast', type: 'success', message: 'Tag deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.tag-manager', [
            'tags' => Tag::latest()->paginate(10),
        ]);
    }
}
