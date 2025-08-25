<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use App\Models\CustomCode;

class CustomCodeEditor extends Component
{
    public $custom_css;
    public $custom_js;

    protected function ensureAdmin()
    {
        if (!auth()->user()->hasAnyRole(['Super Admin'])) {
            abort(403, 'Unauthorized.');
        }
    }

    public function mount()
    {
        $code = CustomCode::first();
        $this->custom_css = $code->custom_css ?? '';
        $this->custom_js = $code->custom_js ?? '';
    }

    public function save()
    {
        $this->ensureAdmin();
        $code = CustomCode::first() ?: new CustomCode();

        $code->custom_css = $this->custom_css;
        $code->custom_js = $this->custom_js;
        $code->save();
        $this->dispatch('toast', type: 'success', message: 'Custom CSS/JS saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.custom-code-editor');
    }
}
