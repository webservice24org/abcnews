<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News\Post;
use Carbon\Carbon;

class PublishScheduledNews extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'news:publish-scheduled';

    /**
     * The console command description.
     */
    protected $description = 'Publish news posts that are scheduled and due for publishing.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Fetch only due scheduled posts
        $scheduledPosts = Post::where('status', 'scheduled')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', $now)
            ->get();

        if ($scheduledPosts->isEmpty()) {
            $this->info("No scheduled posts to publish at this time.");
            return;
        }

        // Publish each one
        foreach ($scheduledPosts as $post) {
            $post->status = 'published';
            $post->published_at = $now; // optional, if you have this column
            $post->save();
        }

        $this->info("Published {$scheduledPosts->count()} scheduled news post(s).");
    }
}
