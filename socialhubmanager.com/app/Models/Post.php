<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['scheduled_at', 'queued_at', 'published_queued'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->select([
            'posts.content',
            'posts.provider',
            'posts.is_instant',
            'posts.status',
            DB::raw('COALESCE(ps.created_at, posts.scheduled_at) AS published_queued'),
            'posts.queued_at',
            'posts.scheduled_at',
            'posts.created_at'
        ])
            ->leftJoin('post_schedule as ps', 'posts.id', '=', 'ps.post_id')
            ->where('posts.user_id', auth()->id());

        if (isset($filters['type'])) {
            if ($filters['type'] === 'queued') {
                $query->where('posts.is_instant', false);
            } else if ($filters['type'] === 'instant') {
                $query->where('posts.is_instant', true);
            }
        }

        if (isset($filters['status'])) {
            $query->where('posts.status', $filters['status']);
        }

        if (isset($filters['search'])) {
            $query->where('posts.content', 'like', '%' . $filters['search'] . '%');
        }

        $query->orderBy('posts.created_at');

        return $query;
    }
}
