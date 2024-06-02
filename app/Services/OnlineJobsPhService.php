<?php

namespace App\Services;

use App\Models\OnlineJobsPhJobListing;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class OnlineJobsPhService
{
    public function __construct()
    {
    }

    public function scrapeJobListings(string $jobKeyword): string
    {
        $response = Http::get(
            'https://www.onlinejobs.ph/jobseekers/jobsearch',
            [
                'jobkeyword' => $jobKeyword,
                'fullTime' => 'on',
                'partTime' => 'on',
                'Freelance' => 'on',
            ]
        );
        $html = $response->body();

        return $html;
    }

    /**
     * @return Collection<int,OnlineJobsPhJobListing>
     */
    public function parseJobListings(string $html): Collection
    {
        $crawler = new Crawler($html);
        $jobs = collect([]);
        $crawler->filter('div.jobpost-cat-box')
            ->each(function (Crawler $jobCrawler) use ($jobs) {
                $title = $jobCrawler->filter('h4')->first()->text();
                $postDetailCrawler = $jobCrawler->filter('p.fs-13.mb-0');
                $postedDate = $postDetailCrawler->attr('data-temp');
                $employer = trim(explode('•', $postDetailCrawler->text())[0]);
                $salary = $jobCrawler->filter('dd.col')->text();
                $shortDescription = $jobCrawler->filter('div.desc')->first()->text();
                $link = $jobCrawler
                    ->filter('div.desc a')
                    ->first()
                    ->attr('href');
                $parts = explode('/', $link);
                $id = end($parts);
                $jobs->add(OnlineJobsPhJobListing::make([
                    'title' => $title,
                    'posting_date' => $postedDate,
                    'employer' => $employer,
                    'salary' => $salary,
                    'short_description' => $shortDescription,
                    'posting_link' => $link,
                    'id' => $id,
                ]));
            });

        return collect($jobs);
    }

    public function scrapeFullDescription(OnlineJobsPhJobListing $job): string
    {
        $response = Http::get(
            "https://www.onlinejobs.ph{$job->posting_link}"
        );
        $html = $response->body();

        return $html;
    }

    public function parseAndSaveFullDescription(string $html): void
    {
        $crawler = new Crawler($html);
        $crawler
            ->filter('#job-description')
            ->first()
            ->each(function (Crawler $descriptionCrawler) {
                $description = $descriptionCrawler->html();
                $id = $descriptionCrawler->attr('data-jobid');
                $job = OnlineJobsPhJobListing::whereId($id)->first();
                if (! $job) {
                    throw new \Exception(
                        'OnlineJobsPhJobListing not found: '.$id
                    );
                }
                $job->description = $description;
                $job->save();
            });
    }

    /**
     * @return Collection<int,OnlineJobsPhJobListing>
     */
    public function getJobs(): Collection
    {
        return OnlineJobsPhJobListing::all();
    }

    public function getUnratedJobs(): Collection
    {
        return OnlineJobsPhJobListing::unrated()
            ->get();
    }
}
