<?php

namespace App\Services;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class LinkedInService implements SocialService
{

    private $clientId;
    private $redirectUri;
    private $clientSecret;

    public function __construct()
    {
        $this->clientId = config('services.linkedin-openid.client_id');
        $this->clientSecret = config('services.linkedin-openid.client_secret');
        $this->redirectUri = config('services.linkedin-openid.redirect');
    }


    public function getAuthorizationUrl()
    {
        $scope = 'openid%20profile%20email%20w_member_social';
        $response_type = 'code';
        $urlString = "https://www.linkedin.com/oauth/v2/authorization?response_type=$response_type&client_id=$this->clientId&redirect_uri=$this->redirectUri&scope=$scope";

        return $urlString;
    }

    public function getAccessToken($code)
    {
        if (empty($code)) {
            throw new \Exception("Código no encontrado en la respuesta");
        }

        $response = $this->postAccessToken($code);
        $accessToken = $response->json('access_token');
        $userData = $this->getUserData($accessToken);

        $socialAccount = SocialAccount::updateOrCreate(
            [
                'provider' => 'linkedin',
                'provider_user_id' => $userData["sub"],
            ],
            [
                'user_id' => auth()->id(),
                'provider_token' => $accessToken,
            ]
        );

        return $socialAccount;
    }

    public function postMessage($socialAccount, string $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $socialAccount->provider_token,
        ])->post('https://api.linkedin.com/v2/ugcPosts', [
            'author' => 'urn:li:person:' . $socialAccount->provider_user_id,
            'lifecycleState' => 'PUBLISHED',
            'specificContent' => [
                'com.linkedin.ugc.ShareContent' => [
                    'shareCommentary' => [
                        'text' => $message,
                    ],
                    'shareMediaCategory' => 'NONE',
                ],
            ],
            'visibility' => [
                'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
            ],
        ]);

        return $response;
    }

    protected function postAccessToken($code)
    {
        return Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'grant_type'    => 'authorization_code',
        ]);
    }

    protected function getUserData($accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.linkedin.com/v2/userinfo');

        return $response->json();
    }
}
