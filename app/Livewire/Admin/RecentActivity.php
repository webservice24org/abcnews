<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\News\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RecentActivity extends Component
{
    public $recentPosts;
    public $postsPerMonth = [];
    public $mostViewedPosts = [];

    public function mount()
    {
        $this->mostViewedPosts = Post::orderByDesc('view_count')->take(8)->get(['news_title', 'slug', 'view_count', 'created_at']);
        $this->recentPosts = Post::latest()->take(8)->get(['news_title', 'slug', 'created_at']);

        // Posts per month (last 6 months)
        $data = Post::select(
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
