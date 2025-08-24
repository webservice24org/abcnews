<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Subscriber;
use App\Models\News\Post;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriberNewsMail;
use App\Models\NewsletterLog;

use Livewire\WithPagination;

class NewsletterSender extends Component
{
    use WithPagination;

    public $subscribers = [];
    public $selectedSubscribers = [];
    public $selectedNews = [];

    protected $paginationTheme = 'tailwind'; 

    public function mount()
    {

        $this->subscribers = Subscriber::where('status', 'active')
                                    ->where('is_agree', 1)
                                    ->get();
    }

    public function sendNewsletter()
    {
        $this->validate([
            'selectedSubscribers' => 'required|array',
            'selectedNews'        => 'required|array',
        ]);

        $newsItems = Post::whereIn('id', $this->selectedNews)->get();

        $subscribers = Subscriber::whereIn('id', $this->selectedSubscribers)
                                ->where('is_agree', 1)
                                ->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new SubscriberNewsMail($subscriber, $newsItems));

            foreach ($newsItems as $news) {
                NewsletterLog::create([
                    'subscriber_id' => $subscriber->id,
                    'news_post_id'  => $news->id,
                    'sent_at'       => now(),
                ]);
            }
        }


        $this->reset(['selectedSubscribers', 'selectedNews']);

        $this->dispatch('toast', type: 'success', message: 'News Letter sent successfully.');
    }

    public function render()
    {

        $newsPosts = Post::where('status', 'published')->paginate(20);

        return view('livewire.admin.newsletter-sender', [
            'newsPosts' => $newsPosts,
        ]);
    }
}
