<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setProviderTokenAttribute($providerToken)
    {
        $this->attributes['provider_token'] = encrypt($providerToken);
    }

    public function setProviderTokenSecretAttribute($providerTokenSecret)
    {
        $this->attributes['provider_token_secret'] = encrypt($providerTokenSecret);
    }

    public function setProviderRefreshTokenAttribute($providerRefreshToken)
    {
        $this->attributes['provider_refresh_token'] = encrypt($providerRefreshToken);
    }

    public function getProviderTokenAttribute($providerToken)
    {
        return decrypt($providerToken);
    }

    public function getProviderTokenSecretAttribute($providerTokenSecret)
    {
        return decrypt($providerTokenSecret);
    }

    public function getProviderRefreshTokenAttribute($providerRefreshToken)
    {
        return decrypt($providerRefreshToken);
    }
}
