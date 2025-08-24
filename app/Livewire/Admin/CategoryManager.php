<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryManager extends Component
{
    use WithPagination;

    public int|null $editingCategoryId = null;
    public string $name = '';
    public string $slug = '';
    public string $filter = 'active'; // 👈 default filter

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
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $this->editingCategoryId,
        ]);

        $slug = $this->slug ?: Str::slug($this->name);

        Category::updateOrCreate(
            ['id' => $this->editingCategoryId],
            [
                'name' => $this->name,
                'slug' => $slug,
                'status' => 1, // 👈 default active when created
            ]
        );

        $this->reset(['name', 'slug', 'editingCategoryId']);

        $this->dispatch('toast', type: 'success', message: 'Category saved successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug ?? '';
    }

    public function confirmDeleteCategory($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    #[\Livewire\Attributes\On('deleteConfirmed')]
    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Category deleted successfully.');
    }

    // 👇 NEW: Toggle status
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->status = $category->status ? 0 : 1;
        $category->save();

        // 👇 Cascade: if category is inactive, set all subs inactive
        if ($category->status == 0) {
            $category->subCategories()->update(['status' => 0]);
        }

        $this->dispatch('toast', 
            type: 'success', 
            message: 'Category status updated to ' . ($category->status ? 'Active' : 'Inactive')
        );
    }


    // 👇 NEW: Switch filter
    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage(); // reset pagination on filter change
    }

    public function render()
    {
        $query = Category::query();

        if ($this->filter === 'active') {
            $query->where('status', 1);
        } elseif ($this->filter === 'inactive') {
            $query->where('status', 0);
        }

        return view('livewire.admin.category-manager', [
            'categories' => $query->latest()->paginate(10),
        ]);
    }
}
