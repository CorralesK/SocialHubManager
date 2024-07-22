<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeForUser($query)
    {
        return $query->where('user_id', auth()->user()->id)
                     ->orderBy('time', 'asc')
                     ->get()
                     ->groupBy('day_of_week');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
