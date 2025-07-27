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
    public $availableSubcategories = [];
    public $selectedSubcategoryId;
    public $customMenuTitle;

    public $editingMenuId = null;
    public $editTitle;
    public $editType;
    public $editSlug;

    


    

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
            if (!Menu::where('type', 'category')->where('type_id', $catId)->exists()) {
                $category = Category::find($catId);
                if ($category) {
                    Menu::create([
                        'title' => $category->name,
                        'type' => 'category',
                        'slug' => $category->slug,
                        'type_id' => $catId,
                        'order' => Menu::max('order') + 1
                    ]);
                }
            }
        }

        foreach ($this->selectedSubCategories as $subCatId) {
            if (!Menu::where('type', 'subcategory')->where('type_id', $subCatId)->exists()) {
                $subcategory = SubCategory::find($subCatId);
                if ($subcategory) {
                    Menu::create([
                        'title' => $subcategory->name,
                        'type' => 'subcategory',
                        'slug' => $subcategory->slug,
                        'type_id' => $subCatId,
                        'order' => Menu::max('order') + 1
                    ]);
                }
            }
        }

        foreach ($this->selectedDivisions as $divId) {
            if (!Menu::where('type', 'division')->where('type_id', $divId)->exists()) {
                $division = Division::find($divId);
                if ($division) {
                    Menu::create([
                        'title' => $division->name,
                        'type' => 'division',
                        'slug' => $division->slug,
                        'type_id' => $divId,
                        'order' => Menu::max('order') + 1
                    ]);
                }
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
    /*
    public function showSubmenuForm($parentId)
    {
        $this->parentIdForSubmenu = $parentId;
        $this->newTitle = '';
        $this->newType = '';
        $this->newTypeId = null;
    }
        */

    public function showSubmenuForm($parentId)
    {
        $this->parentIdForSubmenu = $parentId;
        $this->availableSubcategories = [];

        $menu = Menu::find($parentId);

        // Only for category-type menu items
        if ($menu && $menu->type === 'category' && $menu->type_id) {
            $this->availableSubcategories = \App\Models\SubCategory::where('category_id', $menu->type_id)->get();
        }
    }


    public function createSubmenu()
    {
        $this->validate([
            'selectedSubcategoryId' => 'required|exists:sub_categories,id',
        ]);

        $subcategory = \App\Models\SubCategory::find($this->selectedSubcategoryId);

        Menu::create([
            'title' => $subcategory->name,
            'type' => 'subcategory',
            'type_id' => $subcategory->id,
            'slug' => $subcategory->slug,
            'parent_id' => $this->parentIdForSubmenu,
            'order' => Menu::where('parent_id', $this->parentIdForSubmenu)->max('order') + 1,
        ]);

        $this->reset(['parentIdForSubmenu', 'selectedSubcategoryId', 'availableSubcategories']);
        $this->loadMenu();
    }




    public function editMenu($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $this->editingMenuId = $menuId;
        $this->editTitle = $menu->title;
        $this->editType = $menu->type;
        $this->editOrder = $menu->order;
        $this->editSlug = $menu->slug; // include slug
    }


    public function updateMenu()
{
    $this->validate([
        'editTitle' => 'required|string|max:255',
        'editType' => 'required|string|in:category,subcategory,division,custom',
        'editOrder' => 'nullable|integer',
        'editSlug' => 'nullable|string|max:255'
    ]);

    $menu = Menu::findOrFail($this->editingMenuId);

    $menu->title = $this->editTitle;
    $menu->type = $this->editType;
    $menu->order = $this->editOrder;
    $menu->slug  = $this->editSlug; // update slug
    $menu->save();

    $this->reset(['editingMenuId', 'editTitle', 'editType', 'editOrder', 'editSlug']);
    $this->loadMenu();
}

    


    public function render()
    {
        $menuTree = Menu::whereNull('parent_id')->with('children')->orderBy('order')->get();
        return view('livewire.admin.menu-manager', compact('menuTree'));
    }



    
}
