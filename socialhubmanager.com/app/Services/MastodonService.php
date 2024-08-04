<?php

namespace App\Services;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;

class MastodonService extends SocialService
{
    private $baseUrl = 'https://mastodon.social';

    public function __construct()
    {
        parent::__construct('mastodon');
    }

    public function getAuthorizationUrl()
    {
        $scope = 'read write';
        $urlString = sprintf(
            '%s/oauth/authorize?response_type=code&client_id=%s&redirect_uri=%s&scope=%s&force_login=true',
            $this->baseUrl,
            $this->clientId,
            $this->redirectUri,
            urlencode($scope)
        );

        return $urlString;
    }

    public function getAccessToken($code)
    {
        if (empty($code)) {
            throw new \Exception("Código no encontrado en la respuesta");
        }

        $token = $this->postAccessToken("$this->baseUrl/oauth/token", $code, ['scope' => 'read write']);
        $userData = $this->getUserData("$this->baseUrl/api/v1/accounts/verify_credentials", $token['access_token']);
        $socialAccount = $this->updateOrCreateSocialAccount('mastodon', $userData["id"], $token['access_token']);

        return $socialAccount;
    }

    public function postMessage(SocialAccount $socialAccount, string $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $socialAccount->provider_token,
        ])->post("$this->baseUrl/api/v1/statuses", [
            'status' => $message
        ]);

        if (!$response->successful()) {
            throw new \Exception('No se pudo publicar el mensaje: ' . $response->body());
        }

        return $response->json();
    }
}
