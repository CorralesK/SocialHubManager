<?php

namespace App\Services;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class LinkedInService extends SocialService
{
    private $baseUrl = 'https://api.linkedin.com';

    public function __construct()
    {
        parent::__construct('linkedin-openid');
    }

    public function getAuthorizationUrl()
    {
        $scope = 'openid profile email w_member_social';
        $urlString = sprintf(
            '%s/oauth/v2/authorization?response_type=code&client_id=%s&redirect_uri=%s&scope=%s',
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

        $token = $this->postAccessToken("$this->baseUrl/oauth/v2/accessToken", $code);
        $userData = $this->getUserData("$this->baseUrl/v2/userinfo", $token['access_token']);
        $socialAccount = $this->updateOrCreateSocialAccount('linkedin', $userData["sub"], $token['access_token']);

        return $socialAccount;
    }

    public function postMessage(SocialAccount $socialAccount, string $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $socialAccount->provider_token,
        ])->post("$this->baseUrl/v2/ugcPosts", [
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

        if (!$response->successful()) {
            throw new \Exception('No se pudo publicar el mensaje: ' . $response->body());
        }

        return $response;
    }
}
