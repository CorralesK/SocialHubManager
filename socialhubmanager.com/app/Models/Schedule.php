<?php

namespace App\Models;

use Carbon\Carbon;
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
            ->map(function ($schedule) {
                return $this->convertToLocalTime($schedule);
            })
            ->groupBy('day_of_week');
    }

    public function convertToLocalTime($schedule)
    {
        $date = Carbon::parse("$schedule->day_of_week $schedule->time", 'UTC')
            ->setTimezone('America/Costa_Rica');

        $schedule->day_of_week = $date->format('l');
        $schedule->time = $date->format('H:i');

        return $schedule;
    }

    public static function convertToUTC($dayOfWeek, $time)
    {
        $date = Carbon::parse("$dayOfWeek $time", 'America/Costa_Rica')
            ->setTimezone('UTC');

        return [
            'day_of_week' => $date->format('l'),
            'time' => $date->format('H:i'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
