<?php 

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitorSummary extends Component
{
    public $period = 'daily';   
    public $labels = [];
    public $current = [];
    public $previous = [];

    public function mount()
    {
        $this->loadData();
    }

    public function updatedPeriod()
    {

        $this->loadData();
        $this->dispatch(
            'updateChart',
            labels: $this->labels,
            current: $this->current,
            previous: $this->previous
        );
    }

    public function loadData()
    {
        $this->labels = $this->current = $this->previous = [];

        switch ($this->period) {
            case 'weekly':
                // group by day name for current week and previous week
                $current = DB::table('visitors')
                    ->select(DB::raw('DAYNAME(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->groupBy('label')
                    ->pluck('cnt', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('DAYNAME(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                    ->groupBy('label')
                    ->pluck('cnt', 'label');
                break;

            case 'monthly':
                // group by day of month
                $current = DB::table('visitors')
                    ->select(DB::raw('DAY(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->groupBy('label')
                    ->orderBy('label')
                    ->pluck('cnt', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('DAY(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                    ->groupBy('label')
                    ->pluck('cnt', 'label');
                break;

            case 'yearly':
                // group by month name
                $current = DB::table('visitors')
                    ->select(DB::raw('MONTHNAME(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('label')
                    ->pluck('cnt', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('MONTHNAME(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->groupBy('label')
                    ->pluck('cnt', 'label');
                break;

            default: // daily
                // group by hour for today / yesterday
                $current = DB::table('visitors')
                    ->select(DB::raw('HOUR(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereDate('created_at', Carbon::today())
                    ->groupBy('label')
                    ->orderBy('label')
                    ->pluck('cnt', 'label');

                $previous = DB::table('visitors')
                    ->select(DB::raw('HOUR(created_at) as label'), DB::raw('COUNT(*) as cnt'))
                    ->whereDate('created_at', Carbon::yesterday())
                    ->groupBy('label')
                    ->orderBy('label')
                    ->pluck('cnt', 'label');
                break;
        }

        // Normalize labels (union of both sets), preserving order
        $keys = array_unique(array_merge(array_keys($current->toArray()), array_keys($previous->toArray())));
        // Sorting numeric hours/days/months works better; keep string sorting otherwise
        usort($keys, function ($a, $b) {
            if (is_numeric($a) && is_numeric($b)) return $a - $b;
            return strcmp($a, $b);
        });

        $this->labels = array_values($keys);

        $this->current = array_map(function ($k) use ($current) {
            return (int) ($current[$k] ?? 0);
        }, $this->labels);

        $this->previous = array_map(function ($k) use ($previous) {
            return (int) ($previous[$k] ?? 0);
        }, $this->labels);
    }

    public function getVisitorData()
{
    $query = DB::table('visitors')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->whereYear('created_at', $this->selectedYear);

    if (!empty($this->selectedMonth)) {
        $query->whereMonth('created_at', $this->selectedMonth);
    }

    $data = $query->groupBy('date')->orderBy('date')->get();

    return [
        'labels' => $data->pluck('date'),
        'totals' => $data->pluck('total'),
    ];
}

    public function render()
    {
        return view('livewire.admin.visitor-summary');
    }
}
