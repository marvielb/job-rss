<?php

namespace App\Jobs;

use App\Models\OnlineJobsPhJobListing;
use App\Services\OnlineJobsPhService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;

class ScrapeOnlineJobsPhDescriptionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected OnlineJobsPhJobListing $jobListing)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(OnlineJobsPhService $service): void
    {
        $html = $service->scrapeFullDescription($this->jobListing);
        $service->parseAndSaveFullDescription($html);
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new RateLimited('scraping')];
    }
}
