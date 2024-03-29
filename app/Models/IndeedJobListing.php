<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperIndeedJobListing
 */
class IndeedJobListing extends Model
{
    use HasFactory;

    protected $table = 'indeed_job_listings';

    protected $fillable = ['id', 'title', 'employer', 'location', 'posting_link'];

    protected $casts = ['id' => 'string'];
}
