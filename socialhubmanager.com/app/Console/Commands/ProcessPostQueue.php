<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\SocialService;
use App\Models\User;
use App\Models\Post;
use App\Providers\SocialServiceFactory;

class ProcessPostQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:process-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the posts queue';

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
        $currentDay = Carbon::now()->format('l');
        $currentTime = Carbon::now()->format('H:i');

        $users = User::all();

        foreach ($users as $user) {
            $schedules = $user->schedules()->where('day_of_week', $currentDay)
                                        ->whereRaw('DATE_FORMAT(time, "%H:%i") = ?', [$currentTime])
                                        ->get();
            
            foreach ($schedules as $schedule) {
                $post = $user->posts()->where('status', 'pending')
                                        ->whereNotNull('queued_at')
                                        ->orderBy('queued_at')
                                        ->first();
                
                if ($post) {
                    try {
                        $socialService = SocialServiceFactory::make($post->provider);
                        $socialController = new \App\Http\Controllers\SocialController($socialService);

                        if ($socialController->publishPost($post->provider, $post->id)) {
                            \DB::table('post_schedule')->insert([
                                'post_id' => $post->id,
                                'schedule_id' => $schedule->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }

                    } catch (\Exception $e) {
                        \Log::error('Error al publicar el post: ' . $e->getMessage());
                    }
                    
                    break;
                }
            }
        }
    }

}
