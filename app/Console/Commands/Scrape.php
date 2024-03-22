<?php

namespace App\Console\Commands;

use App\Services\OnlineJobsPhService;
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
    public function handle(OnlineJobsPhService $service): void
    {
        $service->scrapeContents('laravel');
    }
}
