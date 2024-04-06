<?php

namespace Tests\Feature;

use App\Models\OnlineJobsPhJobListing;
use App\Services\OnlineJobsPhService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SearchOnlineJobsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_can_parse_example_data(): void
    {
        $html = file_get_contents(__DIR__.'/SampleData/test.html');
        Http::fake([
            '*' => Http::response($html, 200),
        ]);
        $service = new OnlineJobsPhService();
        $html = $service->scrapeJobListings('laravel');
        $parsedJobs = $service->parseJobListings($html);

        $parsedJobs->each(function (OnlineJobsPhJobListing $job, $i) {
            $exists = OnlineJobsPhJobListing::whereId($job->id)->exists();
            if ($exists) {
                return;
            }
            $job->save();
        });
        $jobs = $service->getJobs();

        $this->assertNotEmpty($jobs);
        $this->assertTrue($jobs->some(fn ($job) => $job->id == 1124047));
    }

    public function test_can_parse_and_save_description(): void
    {
        $html = file_get_contents(
            __DIR__.'/SampleData/test_onlinejobsph_details.html'
        );
        $idFromTestData = 1087815;
        OnlineJobsPhJobListing::factory()->create(['id' => $idFromTestData]);
        $service = new OnlineJobsPhService();
        $service->parseAndSaveFullDescription($html);
        $job = $service->getJobs()->first();
        $this->assertStringContainsString(
            'Develop and Maintain Backend Services: Build and maintain robust backend services using Laravel framework, ensuring high performance and responsiveness to requests from the front end.',
            $job->description
        );
    }
}
