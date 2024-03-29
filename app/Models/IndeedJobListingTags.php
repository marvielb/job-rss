<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperIndeedJobListingTags
 */
class IndeedJobListingTags extends Model
{
    use HasFactory;

    protected $table = 'indeed_job_listings_tags';

    protected $fillable = ['indeed_job_listing_id', 'tag'];
}
