<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\User;
use App\Models\News\Post;
use Livewire\WithPagination;

class UserNews extends Component
{
    use WithPagination;

    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        // Get all posts by this user
        $allNews = Post::with(['categories', 'user'])
            ->where('user_id', $this->user->id)
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $topLeft = $allNews->first();
        $topRight = $allNews->slice(1, 5);

        $excludedIds = $allNews->pluck('id')->toArray();

        $gridNews = Post::with(['categories', 'user'])
            ->where('user_id', $this->user->id)
            ->where('status', 'published')
            ->whereNotIn('id', $excludedIds)
            ->latest()
            ->paginate(8);

        return view('livewire.frontend.user-news', [
            'user' => $this->user,
            'topLeft' => $topLeft,
            'topRight' => $topRight,
            'gridNews' => $gridNews,
        ])->layout('layouts.frontend')->title('News by ' . $this->user->name);
    }
}