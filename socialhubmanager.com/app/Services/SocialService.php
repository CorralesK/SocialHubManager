<?php

namespace App\Services;

interface SocialService
{
    public function getAuthorizationUrl();
    public function getAccessToken($code);
    public function postMessage($socialAccount, string $message);
}
