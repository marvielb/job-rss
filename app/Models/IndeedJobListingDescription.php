<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperIndeedJobListingDescription
 */
class IndeedJobListingDescription extends Model
{
    use HasFactory;

    protected $table = 'indeed_job_listings_descriptions';

    protected $fillable = ['indeed_job_listing_id', 'description'];
}
