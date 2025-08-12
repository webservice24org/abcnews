<?php

namespace App\Livewire\Admin;
use Livewire\Component;
use App\Models\ColorSetting;

class ThemeColorPicker extends Component
{
    public $colors = [];

    public function mount()
    {
        $settings = ColorSetting::first();
        if ($settings) {
            $this->colors = $settings->toArray();
            unset($this->colors['id'], $this->colors['created_at'], $this->colors['updated_at']);
        } else {
            // Default values
            $this->colors = [
                'header_bg' => '#ffffff',
                'nav_item_color' => '#000000',
                'sub_menu_bg' => '#f1f1f1',
                'sub_menu_hover_bg' => '#cccccc',
                'menu_hover' => '#ff0000',
                'sub_menu_hover' => '#ff0000',
                'sec_title_bg' => '#222222',
                'sec_title_color' => '#ffffff',
                'sec_border_color' => '#dddddd',
                'cat_btn_bg' => '#16a34a',
                'cat_btn_color' => '#ffffff',
                'title_color' => '#000000',
                'title_hover_color' => '#ff0000',
                'footer_bg' => '#E7000B',
                'copyright_text_color' => '#333333',
                'dev_text_color' => '#555555',
                'social_icon_bg' => '#000000',
                'social_icon_color' => '#ffffff',
                'social_icon_hover_bg' => '#ff0000'
            ];
        }
    }

    public function save()
    {
        ColorSetting::updateOrCreate([], $this->colors);

        
        $this->dispatch('colorsUpdated', $this->colors);

        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Colors updated successfully.'
        ]);
    }


    public function render()
    {
        return view('livewire.admin.theme-color-picker');
    }
}
