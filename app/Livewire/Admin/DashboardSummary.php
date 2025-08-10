<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NewsPost;
use App\Models\User;

class DashboardSummary extends Component
{
    public $totalPosts;
    public $totalDrafted;
    public $scheduledPosts;
    public $activeUsers;
    public $inactiveUsers;

    public function mount()
    {
        $this->totalPosts = NewsPost::count();
        $this->totalDrafted = NewsPost::where('status', 'draft')->count();
        $this->scheduledPosts = NewsPost::where('scheduled_at', 1)->count();
        $this->activeUsers = User::where('is_active', true)->count();
        $this->inactiveUsers = User::where('is_active', false)->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-summary');
    }
}