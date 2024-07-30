<?php

namespace App\Services;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;

class MastodonService implements SocialService
{
    private $baseUrl = 'https://mastodon.social';
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct()
    {
        $this->clientId = config('services.mastodon.client_id');
        $this->clientSecret = config('services.mastodon.client_secret');
        $this->redirectUri = config('services.mastodon.redirect');
    }

    public function getAuthorizationUrl()
    {
        $responseType = "code";
        $scope = 'read%20write';
        $authorizationUrl = "$this->baseUrl/oauth/authorize?response_type=$responseType&client_id=$this->clientId&redirect_uri=$this->redirectUri&scope=$scope&force_login=true";

        return $authorizationUrl;
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
                'provider' => 'mastodon',
                'provider_user_id' => $userData["id"],
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
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $socialAccount->provider_token,
            ])->post("$this->baseUrl/api/v1/statuses", [
                'status' => $message
            ]);

            if (!$response->successful()) {
                throw new \Exception('No se pudo publicar el mensaje: ' . $response->body());
            }

            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function postAccessToken($code)
    {
        return Http::asForm()->post("$this->baseUrl/oauth/token", [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'scope'         => 'read write',
        ]);
    }

    protected function getUserData($accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get("$this->baseUrl/api/v1/accounts/verify_credentials");

        return $response->json();
    }
}
