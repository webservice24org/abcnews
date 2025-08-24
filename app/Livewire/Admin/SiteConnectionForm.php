<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SiteConnection;

class SiteConnectionForm extends Component
{
    public $siteConnection;

    public $google_verification;
    public $bing_verification;
    public $baidu_verification;
    public $pinterest_verification;
    public $yandex_verification;

    public function mount()
    {
        $this->siteConnection = SiteConnection::first() ?? new SiteConnection();

        $this->google_verification = $this->siteConnection->google_verification;
        $this->bing_verification = $this->siteConnection->bing_verification;
        $this->baidu_verification = $this->siteConnection->baidu_verification;
        $this->pinterest_verification = $this->siteConnection->pinterest_verification;
        $this->yandex_verification = $this->siteConnection->yandex_verification;
    }

    public function save()
    {
        $this->siteConnection->google_verification = $this->google_verification;
        $this->siteConnection->bing_verification = $this->bing_verification;
        $this->siteConnection->baidu_verification = $this->baidu_verification;
        $this->siteConnection->pinterest_verification = $this->pinterest_verification;
        $this->siteConnection->yandex_verification = $this->yandex_verification;

        $this->siteConnection->save();

        $this->dispatch('toast', type: 'success', message: 'Verification codes updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.site-connection-form');
    }
}
