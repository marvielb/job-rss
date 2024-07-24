<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperOnlineJobsPhJobListing
 */
class OnlineJobsPhJobListing extends Model
{
    use HasFactory;

    protected $table = 'onlinejobsph_job_listings';

    protected $fillable = [
        'title',
        'posting_date',
        'employer',
        'salary',
        'description',
        'short_description',
        'posting_link',
        'id',
        'rating',
    ];

    protected $casts = ['posting_date' => 'datetime'];

    public function scopeUnrated(Builder $query): void
    {
        $query->whereNull('rating');
    }

    public function scopeRatingDesc(Builder $query): void
    {
        $query->orderByDesc('rating');
    }
}
