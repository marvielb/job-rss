<?php

namespace App\Http\Controllers;

use App\Services\OnlineJobsPhService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class JobListingsController extends Controller
{
    protected OnlineJobsPhService $onlineJobsPhService;

    public function __construct(OnlineJobsPhService $service)
    {
        $this->onlineJobsPhService = $service;
    }

    public function index(): View|Factory
    {
        $jobs = $this->onlineJobsPhService->getJobs()->map(function ($job) {
            $job->formatted_posting_date = $job->posting_date->format('m/d/Y');

            return $job;
        });

        return view('job_listings.index', compact('jobs'));
    }
}
