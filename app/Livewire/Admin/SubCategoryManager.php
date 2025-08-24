<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class SubCategoryManager extends Component
{
    use WithPagination;

    public $name;
    public $slug; 
    public $category_id;

    public $editingSubCategoryId;
    public $editingName;
    public $editingSlug; 
    public $editingCategoryId;

    public string $filter = 'active';



    protected $rules = [
        'name' => 'required|string|max:255|unique:sub_categories,name',
        'slug' => 'nullable|string|max:255|unique:sub_categories,slug',
        'category_id' => 'required|exists:categories,id',
    ];


    public function saveSubCategory()
    {
        $this->validate();

        SubCategory::create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug ?: Str::slug($this->name),
        ]);

        $this->reset(['category_id', 'name', 'slug']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Sub-category added successfully.']);
    }


    public function editSubCategory($id)
    {
        $sub = SubCategory::findOrFail($id);
        $this->editingSubCategoryId = $sub->id;
        $this->editingName = $sub->name;
        $this->editingSlug = $sub->slug;
        $this->editingCategoryId = $sub->category_id;
    }

    public function updateSubCategory()
    {
        $sub = SubCategory::findOrFail($this->editingSubCategoryId);

        $this->validate([
            'editingName' => 'required|string|max:255|unique:sub_categories,name,' . $sub->id,
            'editingSlug' => 'nullable|string|max:255|unique:sub_categories,slug,' . $sub->id,
            'editingCategoryId' => 'required|exists:categories,id',
        ]);

        $sub->update([
            'name' => $this->editingName,
            'slug' => $this->editingSlug, 
            'category_id' => $this->editingCategoryId,
        ]);

        $this->reset('editingSubCategoryId', 'editingName', 'editingSlug', 'editingCategoryId');
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Sub-category updated successfully.']);
    }


    public function confirmDeleteSubCategory($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    #[On('deleteConfirmed')]
    public function deleteSubCategory($id)
    {
        SubCategory::findOrFail($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Sub-category deleted successfully.']);
    }

    public function toggleStatus($id)
    {
        $subcategory = SubCategory::findOrFail($id);

        if ($subcategory->category->status == 0 && $subcategory->status == 0) {
            $this->dispatch('toast', type: 'error', message: 'Parent category is inactive!');
            return;
        }

        $subcategory->status = !$subcategory->status;
        $subcategory->save();

        $this->dispatch('toast', type: 'success', message: 'Subcategory status updated successfully!');
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;            
        $this->resetPage();                 
    }

    public function render()
    {
        $query = SubCategory::with('category')->latest();

        if ($this->filter === 'active') {
            $query->where('status', 1);
        } elseif ($this->filter === 'inactive') {
            $query->where('status', 0);
        }
        return view('livewire.admin.sub-category-manager', [
            'subCategories' => $query->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
