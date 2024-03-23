<?php

namespace App\Models;

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
        'posting_link',
        'id',
    ];

    protected $casts = ['posting_date' => 'datetime'];
}
