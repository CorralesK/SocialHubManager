<?php

namespace App\Services;

use App\Models\SocialAccount;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService extends SocialService  
{  
    private $client; 
    private $baseUrl = 'https://api.twitter.com/1.1/';  

    public function __construct()  
    {   
        parent::__construct('twitter');
        $this->client = new TwitterOAuth(
            $this->clientId,
            $this->clientSecret
        );
    }  

    public function getAuthorizationUrl()  
    {  
        $requestToken = $this->client->oauth('oauth/request_token', [
            'oauth_callback' => config('services.twitter.redirect')
        ]);
        
        session([
            'oauth_token' => $requestToken['oauth_token'],
            'oauth_token_secret' => $requestToken['oauth_token_secret']
        ]);

        return $this->client->url('oauth/authorize', [
            'oauth_token' => $requestToken['oauth_token']
        ]);
    }  

    public function getAccessToken($oauthVerifier)  
    {  
        $requestToken = [
            'oauth_token' => session('oauth_token'),
            'oauth_token_secret' => session('oauth_token_secret')
        ];

        $this->client->setOauthToken($requestToken['oauth_token'], $requestToken['oauth_token_secret']);
        $accessToken = $this->client->oauth("oauth/access_token", [
            "oauth_verifier" => $oauthVerifier
        ]);

        if (!isset($accessToken['user_id'])) {  
            throw new \Exception("user_id no encontrado en la respuesta");  
        }  
        
        $socialAccount = $this->updateOrCreateSocialAccount(
            'twitter',
            $accessToken['user_id'],
            $accessToken['oauth_token'],
            $accessToken['oauth_token_secret']
        );

        return $socialAccount;  
    } 

    public function postMessage(SocialAccount $socialAccount, string $message)  
    {  
        $this->client->setOauthToken($socialAccount->provider_token, $socialAccount->provider_token_secret);
        $response = $this->client->post('tweets', [
            'text' => $message
        ], ['jsonPayload' => true]);

        if (isset($response->errors)) {
            throw new \Exception('No se pudo publicar el mensaje: ' . json_encode($response->errors));
        }

        return $response;
    } 
}
