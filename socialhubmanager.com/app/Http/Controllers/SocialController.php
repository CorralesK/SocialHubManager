<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return redirect('/posts/create')->with('success', 'Account connected successfully!');
    }
}
