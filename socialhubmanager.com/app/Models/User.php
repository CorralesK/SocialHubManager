<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uses_two_factor',
        'two_factor_secret'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setTwoFactorSecretAttribute($twoFactorSecret)
    {
        $this->attributes['two_factor_secret'] = encrypt($twoFactorSecret);
    }

    public function getTwoFactorSecretAttribute($twoFactorSecret)
    {
        return decrypt($twoFactorSecret);
    }


    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function socialAccount()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
