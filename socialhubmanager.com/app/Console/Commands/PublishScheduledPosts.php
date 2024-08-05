<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\SocialAccount;
use App\Providers\SocialServiceFactory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts at the indicated time.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::where('status', 'pending')
            ->where('scheduled_at', '<=', Carbon::now())
            ->get();

        if ($posts->isEmpty()) {
            Log::channel('scheduled_posts')->info("No pending posts found for scheduled publication.");
        }

        foreach ($posts as $post) {
            $service = SocialServiceFactory::make($post->provider);

            $socialAccount = SocialAccount::where('user_id', $post->user_id)
                ->where('provider', $post->provider)
                ->firstOrFail();

            if (!$socialAccount) {
                Log::channel('scheduled_posts')->error("$post->provider - No social account found for user {$post->user_id}. Post {$post->id} skipped.");
                continue;
            }

            try {
                Log::channel('scheduled_posts')->info("$post->provider - Post {$post->id} for user {$post->user_id} start publishing process.");

                $service->postMessage($socialAccount, $post->content);
                $post->update(['status' => 'published']);

                Log::channel('scheduled_posts')->info("$post->provider - Post {$post->id} for user {$post->user_id} successfully published.");
            } catch (\Exception $e) {
                $post->update(['status' => 'failed']);

                Log::channel('scheduled_posts')->error("$post->provider - Failed to publish post {$post->id} for user {$post->user_id} - " . $e->getMessage());
            }
        }
    }
}
