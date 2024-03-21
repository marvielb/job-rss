<?php

namespace App\Services;

use App\Models\OnlineJobsPhJobListing;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class OnlineJobsPhService
{
    public function __construct()
    {

    }

    public function scrapeContents(string $jobKeyword): void
    {
        $response = Http::get('https://www.onlinejobs.ph/jobseekers/jobsearch',
            [
                'jobkeyword' => $jobKeyword,
                'fullTime' => 'on',
                'partTime' => 'on',
                'Freelance' => 'on',
            ]);
        $html = $response->body();
        $crawler = new Crawler($html);
        $crawler->filter('div.jobpost-cat-box')->each(function (Crawler $jobCrawler) {
            $title = $jobCrawler->filter('h4')->first()->text();
            $postDetailCrawler = $jobCrawler->filter('p.fs-13.mb-0');
            $postedDate = $postDetailCrawler->attr('data-temp');
            $employer = trim(explode('•', $postDetailCrawler->text())[0]);
            $salary = $jobCrawler->filter('dd.col')->text();
            $description = $jobCrawler->filter('div.desc')->first()->text();
            $link = $jobCrawler->filter('div.desc a')->first()->attr('href');
            $parts = explode('/', $link);
            $id = end($parts);

            OnlineJobsPhJobListing::updateOrCreate([
                'title' => $title,
                'posting_date' => $postedDate,
                'employer' => $employer,
                'salary' => $salary,
                'description' => $description,
                'posting_link' => $link,
                'id' => $id,
            ]);
        });
    }

    /**
     * @return Collection<int,OnlineJobsPhJobListing>
     */
    public function getJobs(): Collection
    {
        return OnlineJobsPhJobListing::all();
    }
}
