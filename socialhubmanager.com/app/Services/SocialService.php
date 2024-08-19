<?php

namespace App\Services;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;

abstract class SocialService
{
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    abstract public function getAuthorizationUrl();
    abstract public function getAccessToken($code);
    abstract public function postMessage(SocialAccount $socialAccount, string $message);

    public function __construct($config)
    {
        $this->clientId = config("services.$config.client_id");
        $this->clientSecret = config("services.$config.client_secret");
        $this->redirectUri = config("services.$config.redirect");
    }

    protected function updateOrCreateSocialAccount($provider, $userId, $accessToken, $tokenSecret = null, $refreshToken = null)
    {
        return SocialAccount::updateOrCreate(
            [
                'provider' => $provider,
                'provider_user_id' => $userId,
                'user_id' => auth()->id()
            ],
            [
                'provider_token' => $accessToken,
                'provider_token_secret' => $tokenSecret,
                'provider_refresh_token' => $refreshToken
            ]
        );
    }

    protected function postAccessToken($url, $code, array $additionalParams = [])
    {
        $params = array_merge([
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'grant_type'    => 'authorization_code',
        ], $additionalParams);
        $response = Http::asForm()->post($url, $params);

        return $response->json();
    }

    protected function getUserData($url, $accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($url);

        return $response->json();
    }
}
