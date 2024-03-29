<?php

namespace Tests\Feature;

use App\Services\IndeedService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndeedServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_scrapes_data(): void
    {
        $html = file_get_contents(__DIR__.'/SampleData/test_indeed.html');
        $service = new IndeedService();
        $service->parseContentsAndSave($html);
        $jobs = $service->getJobs();
        $this->assertTrue($jobs->count() != 0);
    }
}
