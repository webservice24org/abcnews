<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CategoryManager extends Component
{
    use WithPagination;

    public $name;
    public $editingCategoryId = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->editingCategoryId,
        ];
    }

    public function mount()
    {
        if (!Auth::check() || Auth::user()->hasRole('Subscriber')) {
            abort(403, 'You are not authorized to view this page.');
        }
    }

    public function saveCategory()
    {
        $this->validate();

        if ($this->editingCategoryId) {
            $category = Category::findOrFail($this->editingCategoryId);
            $category->update(['name' => $this->name]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Category updated successfully.']);
        } else {
            Category::create(['name' => $this->name]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Category added successfully.']);
        }

        $this->reset(['name', 'editingCategoryId']);
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
    }

    public function confirmDeleteCategory($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    #[\Livewire\Attributes\On('deleteConfirmed')]
    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Category deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => Category::latest()->paginate(10),
        ]);
    }
}