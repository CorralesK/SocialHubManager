<?php

namespace App\Services;

class SocialServiceFactory
{
    public static function make($provider)
    {
        switch ($provider) {
            case 'twitter':
                return new TwitterService();
            case 'linkedin':
                return new LinkedInService();
            case 'mastodon':
                return new MastodonService();
            default:
                throw new \Exception("Unsupported provider: {$provider}");
        }
    }
}
