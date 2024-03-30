<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperIndeedJobListing
 */
class IndeedJobListing extends Model
{
    use HasFactory;

    protected $table = 'indeed_job_listings';

    protected $fillable = ['indeed_id', 'title', 'employer', 'location', 'posting_link'];

    public function tags(): HasMany
    {
        return $this->hasMany(IndeedJobListingTag::class, 'indeed_job_listing_id', 'id');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(IndeedJobListingDescription::class, 'indeed_job_listing_id');
    }
}
