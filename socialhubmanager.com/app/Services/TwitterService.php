<?php

namespace App\Services;

use App\Models\SocialAccount;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService implements SocialService  
{  
    private $client; 
    private $baseUrl = 'https://api.twitter.com/1.1/';  

    public function __construct()  
    {   
        $this->client = new TwitterOAuth(
            config('services.twitter.client_id'), 
            config('services.twitter.client_secret')
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

        $socialAccount = SocialAccount::updateOrCreate(  
            [  
                'provider' => 'twitter',  
                'provider_user_id' => $accessToken['user_id'],  
            ],  
            [  
                'user_id' => auth()->id(),
                'provider_token' => $accessToken['oauth_token'],  
                'provider_token_secret' => $accessToken['oauth_token_secret'],  
            ]  
        );  

        return $socialAccount;  
    } 

    public function postMessage($socialAccount, string $message)  
    {  
        $this->client->setOauthToken($socialAccount->provider_token, $socialAccount->provider_token_secret);

        $result = $this->client->post('statuses/update', [
            'status' => $message
        ]);

        if (isset($result->errors)) {
            throw new \Exception("No se pudo publicar el mensaje: " . json_encode($result->errors));
        }

        return $result;
    }  
}
