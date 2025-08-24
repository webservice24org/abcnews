<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;

class ClearCache extends Component
{
    public function clear()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        $this->dispatch('toast', type: 'success', message: 'Cache cleared successfully!');
    }

    public function render()
    {
        return view('livewire.admin.clear-cache');
    }
}
