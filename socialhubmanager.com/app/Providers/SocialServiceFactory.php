<?php

namespace App\Providers;

use App\Services\LinkedInService;
use App\Services\MastodonService;
use App\Services\TwitterService;

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
