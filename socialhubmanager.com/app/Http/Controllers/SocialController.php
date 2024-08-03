<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Services\SocialService;
use App\Models\SocialAccount;

class SocialController extends Controller
{
    protected $service;

    public function __construct(SocialService $service)
    {
        $this->service = $service;
    }

    public function redirect()
    {
        $url = $this->service->getAuthorizationUrl();
        return redirect($url);
    }

    public function callback(Request $request)
    {
        if ($request->has('oauth_token') && $request->has('oauth_verifier')) {
            $oauthVerifier = $request->input('oauth_verifier');
            $socialAccount = $this->service->getAccessToken($oauthVerifier);
        } else {
            $socialAccount = $this->service->getAccessToken($request->code);
        }

        return redirect('/post/create')->with('success', 'Account connected successfully!');
    }

    public function publishPost($provider, $postId)
    {
        $post = Post::findOrFail($postId);

        $socialAccount = SocialAccount::where('user_id', $post->user_id)
                                    ->where('provider', $provider)
                                    ->firstOrFail();

        if (!$this->service->postMessage($socialAccount, $post->content)) {
            $post->update(['status' => 'failed']);
            return back()->with('error', 'Failed to publish the post.');
        }

        $post->update(['status' => 'published']);
        return back()->with('success', 'Post published successfully!');
    }
}
