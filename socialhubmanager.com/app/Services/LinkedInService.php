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
        $scope = 'openid%20profile%20email%20w_member_social';
        $response_type = 'code';
        $urlString = "$this->baseUrl/oauth/v2/authorization?response_type=$response_type&client_id=$this->clientId&redirect_uri=$this->redirectUri&scope=$scope";

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
