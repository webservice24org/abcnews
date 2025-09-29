<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\HomepageLeadSection;

class HomepageLeadSectionManager extends Component
{
    public $enabled = true;
    public $design = 'design1';

    public array $designOptions = [
        'design1' => [
            'label' => 'Lead News with Sub Lead and Ad',
            'preview' => '/storage/home_preview/lead-design1.png',
        ],
        'design2' => [
            'label' => 'Only Lead News',
            'preview' => '/storage/home_preview/lead-design2.png',
        ],
        'middle-lead' => [
            'label' => 'Middle Lead Section (1 center, 2 left, 4 right)',
            'preview' => '/storage/home_preview/middle-lead-section.png',
        ],
        'lead-news-alt' => [
            'label' => 'Middle Lead Section (1 center, 2 left, 5 right, 4 bottom)',
            'preview' => '/storage/home_preview/middle-alt-section.png',
        ],
    ];


    public function mount()
    {
        $settings = HomepageLeadSection::first();
        if ($settings) {
            $this->enabled = $settings->enabled;
            $this->design = $settings->design;
        }
    }

    public function save()
    {
        HomepageLeadSection::updateOrCreate(
            ['id' => 1], // only one row
            [
                'enabled' => $this->enabled,
                'design'  => $this->design,
            ]
        );

        $this->dispatch('toast', type: 'success', message: 'Lead Section updated!');
    }

    public function render()
    {
        return view('livewire.admin.homepage-lead-section-manager');
    }
}
