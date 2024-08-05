<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SocialAccount;
use Carbon\Carbon;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        if (!empty($request['scheduled_at'])) {
            $scheduledAtUTC = Carbon::createFromFormat('Y-m-d\TH:i', $request['scheduled_at'], 'America/Costa_Rica')->setTimezone('UTC');
            $request['scheduled_at'] = $scheduledAtUTC;
        }

        $attributes = $request->validate([
            'content' => 'required|string',
            'provider' => 'required|string',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $attributes['user_id'] = auth()->id();
        $attributes['status'] = 'pending';

        $post = Post::create($attributes);

        if ($request->publish_option === 'now') {
            $post->update(['is_instant' => true]);
            return redirect("auth/{$post->provider}/publish/{$post->id}");
        } elseif ($request->publish_option === 'queue') {
            $post->update(['queued_at' => now()]);
            return redirect('/post/create')->with('success', 'Post queued successfully.');
        } elseif ($request->publish_option === 'schedule') {

            if (!isset($attributes['scheduled_at'])) {
                return redirect('/post/create')->with('error', 'Scheduling date is required.');
            }

            $post->update(['scheduled_at' => $attributes['scheduled_at']]);
            return redirect('/post/create')->with('success', 'Post scheduled successfully.');
        }
    }
}
