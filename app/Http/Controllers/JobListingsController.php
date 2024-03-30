<?php

namespace App\Http\Controllers;

use App\Services\IndeedService;
use App\Services\OnlineJobsPhService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class JobListingsController extends Controller
{
    public function __construct(protected OnlineJobsPhService $onlineJobsPhService, protected IndeedService $indeedService)
    {
    }

    public function index(): View|Factory
    {
        $onlineJobsPhJobs = $this->onlineJobsPhService->getJobs()->map(function ($job) {
            $job->formatted_posting_date = $job->posting_date->format('m/d/Y');
            $job->platform = 'online_jobs_ph';

            return $job;
        });

        $indeedJobs = $this->indeedService->getJobs()->map(function ($job) {
            $job->formatted_posting_date = $job->created_at->format('m/d/Y');
            $job->platform = 'indeed';

            return $job;
        });

        $jobs = $onlineJobsPhJobs->merge($indeedJobs);

        return view('job_listings.index', compact('jobs'));
    }
}
