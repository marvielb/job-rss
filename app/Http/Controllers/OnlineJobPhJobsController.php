<?php

namespace App\Http\Controllers;

use App\Http\Resources\OnlineJobPhListingResource;
use App\Services\OnlineJobsPhService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OnlineJobPhJobsController extends Controller
{
    public function __construct(protected OnlineJobsPhService $service)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            /**
             * Wether to show only jobs that are ready to be processed.
             * If the value is truthy, like 1, then it jobs will be filtered.
             */
            'only_onrated' => 'integer',
        ]);

        $jobs = $validated && $validated['only_onrated']
            ? $this->service->getUnratedJobs()
            : $this->service->getJobs();

        return OnlineJobPhListingResource::collection($jobs);
    }
}
