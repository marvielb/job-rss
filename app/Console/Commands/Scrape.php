<?php

namespace App\Console\Commands;

use App\Jobs\ScrapeIndeedJob;
use App\Jobs\ScrapeOnlineJobsPhJob;
use Illuminate\Console\Command;

class Scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes the websites and searches for the terms in the config';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        ScrapeOnlineJobsPhJob::dispatch();
        // Temporarily disabled indeed, as it's too resource intensive
        // ScrapeIndeedJob::dispatch();
    }
}
