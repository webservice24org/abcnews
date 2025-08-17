<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Subscriber;
use App\Models\NewsPost;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriberNewsMail;
use App\Models\NewsletterLog;

class NewsletterSender extends Component
{
    public $subscribers = [];
    public $newsPosts = [];
    public $selectedSubscribers = [];
    public $selectedNews = [];

    public function mount()
{
    // Only active subscribers who agreed
    $this->subscribers = Subscriber::where('status', 'active')
                                   ->where('is_agree', 1)
                                   ->get();

    $this->newsPosts = NewsPost::where('status', 'published')->get();
}


    public function sendNewsletter()
{
    $this->validate([
        'selectedSubscribers' => 'required|array',
        'selectedNews'        => 'required|array',
    ]);

    $newsItems = NewsPost::whereIn('id', $this->selectedNews)->get();

    // Only get subscribers who agreed
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

    $this->dispatch('toast', type: 'success', message: 'News Letter sent successfully.');
}


    public function render()
    {
        return view('livewire.admin.newsletter-sender');
    }
    
}
