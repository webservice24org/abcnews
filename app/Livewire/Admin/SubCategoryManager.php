<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class SubCategoryManager extends Component
{
    use WithPagination;

    public $name;
    public $category_id;
    public $editingSubCategoryId;
    public $editingName;
    public $editingCategoryId;

    protected $rules = [
        'name' => 'required|string|max:255|unique:sub_categories,name',
        'category_id' => 'required|exists:categories,id',
    ];

    public function saveSubCategory()
    {
        $this->validate();

        SubCategory::create([
            'name' => $this->name,
            'category_id' => $this->category_id,
        ]);

        $this->reset('name', 'category_id');
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Sub-category added successfully.']);
    }

    public function editSubCategory($id)
    {
        $sub = SubCategory::findOrFail($id);
        $this->editingSubCategoryId = $sub->id;
        $this->editingName = $sub->name;
        $this->editingCategoryId = $sub->category_id;
    }

    public function updateSubCategory()
    {
        $sub = SubCategory::findOrFail($this->editingSubCategoryId);

        $this->validate([
            'editingName' => 'required|string|max:255|unique:sub_categories,name,' . $sub->id,
            'editingCategoryId' => 'required|exists:categories,id',
        ]);

        $sub->update([
            'name' => $this->editingName,
            'category_id' => $this->editingCategoryId,
        ]);

        $this->reset('editingSubCategoryId', 'editingName', 'editingCategoryId');
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

    public function render()
    {
        return view('livewire.admin.sub-category-manager', [
            'subCategories' => SubCategory::with('category')->latest()->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
