<?php

namespace App\Livewire\Admin\Google;

use Livewire\Component;
use App\Models\AnalyticsConfig;
use Illuminate\Support\Facades\Storage;

class AnalyticsSettings extends Component
{
    public $property_id;
    public $service_account_json;

    public function mount()
    {
        $config = AnalyticsConfig::first();
        if ($config) {
            $this->property_id = $config->property_id;
            $this->service_account_json = $config->service_account_json;
        }
    }

    public function save()
    {
        $data = [
            'property_id' => $this->property_id,
            'service_account_json' => $this->service_account_json,
        ];

        AnalyticsConfig::updateOrCreate(['id' => 1], $data);

        // Save service account JSON to storage path
        Storage::put('analytics/service-account-credentials.json', $this->service_account_json);

        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Analytics settings saved successfully!',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.google.analytics-settings');
    }
}

