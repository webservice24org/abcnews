<?php


namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Division;
use App\Models\Menu;
use Livewire\Attributes\On;

class MenuManager extends Component
{
    public $categories = [];
    public $subcategories = [];
    public $divisions = [];

    public $selectedCategories = [];
    public $selectedSubCategories = [];
    public $selectedDivisions = [];

    public $menuItems = [];
    public $newTitle = '';
    public $newType = '';
    public $editOrder = '';
    public $newTypeId = null;
    public $parentIdForSubmenu = null;
    public $customMenuTitle;

    public $editingMenuId = null;
    public $editTitle;
    public $editType;

    

    public function mount()
    {
        $this->categories = Category::with('subcategories')->get();
        $this->divisions = Division::all();
        $this->loadMenu();
    }

    public function loadMenu()
    {
        $this->menuItems = Menu::whereNull('parent_id')->with('children')->orderBy('order')->get();
    }

    public function addCustomMenu()
    {
        $this->validate([
            'customMenuTitle' => 'required|string|max:255',
        ]);

        Menu::create([
            'title' => $this->customMenuTitle,
            'type' => 'custom', // Optional type for identification
            'parent_id' => null,
            'order' => Menu::max('order') + 1,
        ]);

        $this->customMenuTitle = '';
        $this->loadMenu(); // If you're using eager loading
    }


    public function addToMenu()
    {
        foreach ($this->selectedCategories as $catId) {
            $exists = Menu::where('type', 'category')->where('type_id', $catId)->exists();
            if (!$exists) {
                $order = Menu::max('order') + 1;
                $category = Category::find($catId);
                Menu::create([
                    'title' => $category->name,
                    'type' => 'category',
                    'type_id' => $catId,
                    'order' => $order
                ]);
            }
        }

        foreach ($this->selectedSubCategories as $subCatId) {
            $exists = Menu::where('type', 'subcategory')->where('type_id', $subCatId)->exists();
            if (!$exists) {
                $order = Menu::max('order') + 1;
                $subcategory = SubCategory::find($subCatId);
                Menu::create([
                    'title' => $subcategory->name,
                    'type' => 'subcategory',
                    'type_id' => $subCatId,
                    'order' => $order
                ]);
            }
        }

        foreach ($this->selectedDivisions as $divId) {
            $exists = Menu::where('type', 'division')->where('type_id', $divId)->exists();
            if (!$exists) {
                $order = Menu::max('order') + 1;
                $division = Division::find($divId);
                Menu::create([
                    'title' => $division->name,
                    'type' => 'division',
                    'type_id' => $divId,
                    'order' => $order
                ]);
            }
        }

        $this->reset(['selectedCategories', 'selectedSubCategories', 'selectedDivisions']);
        $this->loadMenu();
    }

    public function removeMenu($menuId)
    {
        Menu::findOrFail($menuId)->delete();
        $this->loadMenu();
    }

    public function showSubmenuForm($parentId)
    {
        $this->parentIdForSubmenu = $parentId;
        $this->newTitle = '';
        $this->newType = '';
        $this->newTypeId = null;
    }

    public function createSubmenu()
{
    $this->validate([
        'newTitle' => 'required|string|max:255',
        'newType' => 'required|string|in:custom,category,subcategory,division',
        'newTypeId' => 'required_if:newType,category,subcategory,division|nullable|integer',
    ]);

    Menu::create([
        'title' => $this->newTitle,
        'type' => $this->newType,
        'type_id' => $this->newTypeId,
        'parent_id' => $this->parentIdForSubmenu,
        'order' => Menu::where('parent_id', $this->parentIdForSubmenu)->max('order') + 1,
    ]);

    $this->reset(['newTitle', 'newType', 'newTypeId', 'parentIdForSubmenu']);
    $this->loadMenu();
}



    public function editMenu($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $this->editingMenuId = $menuId;
        $this->editTitle = $menu->title;
        $this->editType = $menu->type;
        $this->editOrder = $menu->order;
    }

    public function updateMenu()
    {
        $menu = Menu::findOrFail($this->editingMenuId);

        $menu->title = $this->editTitle;
        $menu->type = $this->editType;
        $menu->order = $this->editOrder;
        $menu->save();

        $this->editingMenuId = null;
        $this->loadMenu(); // reload updated menu list
    }
    


    public function render()
    {
        $menuTree = Menu::whereNull('parent_id')->with('children')->orderBy('order')->get();
        return view('livewire.admin.menu-manager', compact('menuTree'));
    }



    
}
