<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NewsPost;
use App\Models\User;
use App\Models\Subscriber;


class DashboardSummary extends Component
{
    public $totalPosts;
    public $totalDrafted;
    public $scheduledPosts;
    public $activeUsers;
    public $inactiveUsers;
    public $subscribers;

    public function mount()
    {
        $this->totalPosts = NewsPost::count();
        $this->totalDrafted = NewsPost::where('status', 'draft')->count();
        $this->scheduledPosts = NewsPost::where('scheduled_at', 1)->count();
        $this->activeUsers = User::where('is_active', true)->count();
        $this->inactiveUsers = User::where('is_active', false)->count();
        $this->subscribers = Subscriber::where('status', 'active')->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-summary');
    }
}