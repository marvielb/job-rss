<?php

namespace App\Http\Controllers;

use App\Http\Resources\OnlineJobPhListingResource;
use App\Models\OnlineJobsPhJobListing;
use App\Services\OnlineJobsPhService;
use Illuminate\Http\JsonResponse;
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

    public function rate(Request $request, OnlineJobsPhJobListing $job): JsonResponse
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:0|max:100', // 1 to 5 stars rating
        ]);
        dd($validated);

        $this->service->rateJob($job, $validated['rating']);

        return response()->json(['message' => 'Job rated successfully.'], 200);
    }
}
