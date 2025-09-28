<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\UnderConstruction;
use Carbon\Carbon;

class UnderConstructionBanner extends Component
{
    public $banner;
    public $days = 0;
    public $hours = 0;
    public $minutes = 0;
    public $seconds = 0;

    protected $listeners = ['tick' => 'updateCountdown'];

    public function mount()
    {
        $this->banner = UnderConstruction::where('status', 1)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->first();

        if ($this->banner) {
            $this->updateCountdown();
        }
    }
    


    public function updateCountdown()
    {
        if (!$this->banner) return;

        $now = Carbon::now();
        $end = Carbon::parse($this->banner->end_time);

        if ($now->gte($end)) {
            $this->banner = null;
            return;
        }

        $totalSeconds = $end->diffInSeconds($now);

        $this->days = floor($totalSeconds / 86400);
        $this->hours = floor(($totalSeconds % 86400) / 3600);
        $this->minutes = floor(($totalSeconds % 3600) / 60);
        $this->seconds = $totalSeconds % 60;
    }

    public function render()
    {
        return view('livewire.frontend.under-construction-banner');
    }
}
