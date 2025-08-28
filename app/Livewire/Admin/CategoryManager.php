<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryManager extends Component
{
    use WithPagination;

    public int|null $editingCategoryId = null;
    public string $name = '';
    public string $slug = '';
    public string $filter = 'active'; 
    public string $search = '';

    // ✅ Sorting
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
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
                'status' => 1,
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

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->status = $category->status ? 0 : 1;
        $category->save();

        if ($category->status == 0) {
            $category->subCategories()->update(['status' => 0]);
        }

        $this->dispatch('toast',
            type: 'success',
            message: 'Category status updated to ' . ($category->status ? 'Active' : 'Inactive')
        );
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $query = Category::query()
            ->when($this->search, function ($q) {
                $q->where(function ($subQuery) {
                    $subQuery->where('name', 'like', "%{$this->search}%")
                             ->orWhere('slug', 'like', "%{$this->search}%");
                });
            });

        if ($this->filter === 'active') {
            $query->where('status', 1);
        } elseif ($this->filter === 'inactive') {
            $query->where('status', 0);
        }

        $categories = $query->orderBy($this->sortField, $this->sortDirection)
                            ->paginate(10);

        return view('livewire.admin.category-manager', compact('categories'));
    }
}
