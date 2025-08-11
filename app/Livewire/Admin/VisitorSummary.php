<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VisitorSummary extends Component
{
    public $labels = [];
    public $current = [];
    public $previous = [];
    public $period = 'daily'; // default

    public function mount()
    {
        $this->loadData();
    }

    public function updatedPeriod()
    {
        $this->loadData();
        $this->dispatch('refreshChart', [
            'labels' => $this->labels,
            'current' => $this->current,
            'previous' => $this->previous,
        ]);
    }

    private function loadData()
    {
        switch ($this->period) {
            case 'weekly':
                $current = DB::table('visitors')
                    ->select(DB::raw('DAYNAME(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->groupBy('label')
                    ->pluck('count', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('DAYNAME(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                    ->groupBy('label')
                    ->pluck('count', 'label');
                break;

            case 'monthly':
                $current = DB::table('visitors')
                    ->select(DB::raw('DAY(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->groupBy('label')
                    ->pluck('count', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('DAY(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                    ->groupBy('label')
                    ->pluck('count', 'label');
                break;

            case 'yearly':
                $current = DB::table('visitors')
                    ->select(DB::raw('MONTHNAME(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('label')
                    ->pluck('count', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('MONTHNAME(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->groupBy('label')
                    ->pluck('count', 'label');
                break;

            default: // daily
                $current = DB::table('visitors')
                    ->select(DB::raw('HOUR(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereDate('created_at', Carbon::today())
                    ->groupBy('label')
                    ->pluck('count', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('HOUR(created_at) as label'), DB::raw('COUNT(*) as count'))
                    ->whereDate('created_at', Carbon::yesterday())
                    ->groupBy('label')
                    ->pluck('count', 'label');
                break;
        }

        $this->labels = array_keys($current->toArray());
        $this->current = array_values($current->toArray());
        $this->previous = array_values($previous->toArray());
    }

    public function render()
    {
        return view('livewire.admin.visitor-summary');
    }
}