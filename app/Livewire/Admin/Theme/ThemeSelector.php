<?php

namespace App\Livewire\Admin\Theme;

use Livewire\Component;
use App\Models\ThemeSettings;
use Illuminate\Support\Facades\DB;

class ThemeSelector extends Component
{
    public $themes = [];
    public $activeTheme;
    public $previewTheme;

public function mount()
{
    $this->themes = [
        [
            'id' => 'theme1',
            'name' => 'Theme 1',
            'thumbnail' => asset('storage/theme/theme1.png')
        ],
        [
            'id' => 'theme2',
            'name' => 'Theme 2',
            'thumbnail' => asset('storage/theme/theme2.png')
        ],
        [
            'id' => 'theme3',
            'name' => 'Theme 3',
            'thumbnail' => asset('storage/theme/theme3.png')
        ],
    ];

    // Load from DB (fallback to theme1 if not set)
     $dbTheme = DB::table('theme_settings')
        ->where('key', 'selected_theme')
        ->value('value');
    $this->activeTheme = $dbTheme ?? 'theme1';
    $this->previewTheme = $this->activeTheme;
}


    public function preview($themeId)
    {
        $this->previewTheme = $themeId; // apply class on the fly
        $this->dispatch('theme-changed', theme: $themeId);
    }

public function save()
{
    DB::table('theme_settings')->updateOrInsert(
        ['key' => 'selected_theme'],
        ['value' => $this->previewTheme]
    );

    $this->activeTheme = $this->previewTheme;

    $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Theme saved successfully!',
        ]);
}

    public function render()
    {
        return view('livewire.admin.theme.theme-selector');
    }
   
}
