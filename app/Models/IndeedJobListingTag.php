<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperIndeedJobListingTag
 */
class IndeedJobListingTag extends Model
{
    use HasFactory;

    protected $table = 'indeed_job_listings_tags';

    protected $fillable = ['indeed_job_listing_id', 'tag'];

    protected $casts = ['indeed_job_listing_id' => 'string'];
}
