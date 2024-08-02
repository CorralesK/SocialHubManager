<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SocialAccount;
use App\Services\SocialService;

class PostController extends Controller
{
    protected $socialService;

    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'publish_option' => 'required|string|in:now,queue,schedule',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->content = $validatedData['content'];
        $post->status = 'pending';

        if ($validatedData['publish_option'] === 'schedule' && $validatedData['scheduled_at']) {
            $post->status = 'pending';
            $post->scheduled_at = $validatedData['scheduled_at'];
        } elseif ($validatedData['publish_option'] === 'queue') {
            $post->status = 'pending';
            $post->queued_at = now();
        } else {
            $post->status = 'published';
            $post->is_instant = true;
        }

        $post->save();

        if ($validatedData['publish_option'] === 'now') {
            $this->publishPost($post);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    protected function publishPost(Post $post)
    {
        $user = $post->user;
        $socialAccounts = SocialAccount::where('user_id', $user->id)->get();

        foreach ($socialAccounts as $socialAccount) {
            $this->socialService->postMessage($socialAccount, $post->content);
        }

        $post->status = 'published';
        $post->save();
    }
}
