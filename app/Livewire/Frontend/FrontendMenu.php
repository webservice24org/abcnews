<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Menu;

use App\Models\SiteSetting;

class FrontendMenu extends Component
{
    public function render()
    {
        $menuTree = Menu::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        $siteSetting = SiteSetting::first();

        return view('livewire.frontend.frontend-menu', compact('menuTree', 'siteSetting'));
    }
}
