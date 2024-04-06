<?php

namespace App\Jobs;

use App\Models\OnlineJobsPhJobListing;
use App\Services\OnlineJobsPhService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeOnlineJobsPhJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(OnlineJobsPhService $service): void
    {
        $html = $service->scrapeJobListings('laravel');
        $jobs = $service->parseJobListings($html);
        $jobs->each(function (OnlineJobsPhJobListing $job) {
            $exists = OnlineJobsPhJobListing::whereId($job->id)->exists();

            if ($exists) {
                return;
            }

            if (! $job->save()) {
                return;
            }

            ScrapeOnlineJobsPhDescriptionJob::dispatch($job);
        });
    }
}
