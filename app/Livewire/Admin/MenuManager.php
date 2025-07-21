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

    //protected $listeners = ['updateMenuOrder'];

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

    #[On('updateMenuOrder')]
    public function updateMenuOrder(array $structure)
    {
        \Log::info('updateMenuOrder called with:', $structure);

        $this->updateMenuHierarchy($structure);

        $this->loadMenu();

    }


    // Recursive update of order and parent_id
   public function updateMenuHierarchy(array $items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            Menu::where('id', $item['id'])->update([
                'parent_id' => $parentId,
                'order' => $index
            ]);

            if (!empty($item['children'])) {
                $this->updateMenuHierarchy($item['children'], $item['id']);
            }
        }
    }


    public function render()
    {
        return view('livewire.admin.menu-manager');
    }
}
