<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setProviderTokenAttribute($providerToken)
    {
        $this->attributes['provider_token'] = !empty($providerToken) ? encrypt($providerToken) : null;
    }

    public function setProviderTokenSecretAttribute($providerTokenSecret)
    {
        $this->attributes['provider_token_secret'] = !empty($providerTokenSecret) ? encrypt($providerTokenSecret) : null;
    }

    public function setProviderRefreshTokenAttribute($providerRefreshToken)
    {
        $this->attributes['provider_refresh_token'] = !empty($providerRefreshToken) ? encrypt($providerRefreshToken) : null;
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
