<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NewsPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RecentActivity extends Component
{
    public $mostViewedPosts;
    public $recentPosts;
    public $postsPerMonth = [];

    public function mount()
    {
        $this->mostViewedPosts = NewsPost::orderByDesc('view_count')->take(8)->get(['news_title', 'slug', 'view_count']);
        $this->recentPosts = NewsPost::latest()->take(8)->get(['news_title', 'slug', 'created_at']);

        // Posts per month (last 6 months)
        $data = NewsPost::select(
            DB::raw('COUNT(*) as total'),
            DB::raw('MONTH(created_at) as month')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

        $this->postsPerMonth = [
            'labels' => collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('M'))->toArray(),
            'data' => array_replace(array_fill(0, 12, 0), $data)
        ];
    }

    public function render()
    {
        return view('livewire.admin.recent-activity');
    }
}
