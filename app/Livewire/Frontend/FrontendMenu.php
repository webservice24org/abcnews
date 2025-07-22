<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Menu;

class FrontendMenu extends Component
{
    public function render()
    {
        $menuTree = Menu::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        return view('livewire.frontend.frontend-menu', compact('menuTree'));
    }
}
