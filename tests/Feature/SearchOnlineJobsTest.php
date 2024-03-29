<?php

namespace Tests\Feature;

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
        $service->scrapeContents('laravel');
        $jobs = $service->getJobs();

        $this->assertNotEmpty($jobs);
        $this->assertTrue($jobs->some(fn ($job) => $job->id == 1124047));
    }
}
