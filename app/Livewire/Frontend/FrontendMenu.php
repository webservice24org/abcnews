<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Menu;
use App\Models\SiteSetting;
use App\Models\Category;

class FrontendMenu extends Component
{
    public function render()
    {
        // Existing menu tree
        $menuTree = Menu::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        // Site settings
        $siteSetting = SiteSetting::first();

        // Active categories with active subcategories
        $categories = Category::with(['subcategories' => function($q) {
                $q->where('status', 1)->orderBy('name');
            }])
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('livewire.frontend.frontend-menu', compact('menuTree', 'siteSetting', 'categories'));
    }
}

