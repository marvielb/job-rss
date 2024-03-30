<?php

namespace App\Services;

use App\Models\IndeedJobListing;
use App\Models\IndeedJobListingDescription;
use App\Models\IndeedJobListingTag;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\DomCrawler\Crawler;

class IndeedService
{
    public function __construct()
    {

    }

    public function scrapeContents(string $jobKeyword): string
    {

        $serverUrl = 'http://browser:4444';
        $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::firefox());
        // Go to URL
        $driver->get('https://ph.indeed.com/');

        // Find search element by its id, write 'PHP' inside and submit
        $driver->findElement(WebDriverBy::id('text-input-what')) // find search input element
            ->sendKeys($jobKeyword) // fill the search box
            ->submit(); // submit the whole form

        // Find element of 'History' item in menu by its css selector
        $historyButton = $driver->findElement(
            WebDriverBy::cssSelector('button.yosegi-InlineWhatWhere-primaryButton')
        );

        // Click the element to navigate to revision history page
        $historyButton->click();

        $wait = new WebDriverWait($driver, 30);
        $wait->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('mosaic-provider-jobcards'))
        );
        $html = $driver->getPageSource();
        // Make sure to always call quit() at the end to terminate the browser session
        $driver->quit();

        return $html;
    }

    public function parseContentsAndSave(string $html): void
    {
        $crawler = new Crawler($html);
        $crawler->filter('#mosaic-provider-jobcards ul li')->each(function (Crawler $jobCrawler) {
            if ($jobCrawler->filter('h2.jobTitle a span')->count() == 0) {
                return;
            }

            $id = $jobCrawler->filter('a.jcs-JobTitle')->attr('data-jk');
            $postingLink = $jobCrawler->filter('a.jcs-JobTitle')->attr('href');
            $title = $jobCrawler->filter('h2.jobTitle a span')->text();
            $companyInfoCrawler = $jobCrawler->filter('div.company_location div')->first();
            $companyName = $companyInfoCrawler->filter('span')->text();
            $companyLocation = $companyInfoCrawler->filter('div div')->text();
            $job = IndeedJobListing::updateOrCreate([
                'indeed_id' => $id,
                'title' => $title,
                'employer' => $companyName,
                'location' => $companyLocation,
                'posting_link' => $postingLink,
            ]);
            $jobCrawler->filter('div.jobMetaDataGroup div.metadataContainer div')->each(function (Crawler $metaCrawler) use ($job) {
                IndeedJobListingTag::updateOrCreate(['indeed_job_listing_id' => $job->id, 'tag' => $metaCrawler->text()]);
            });

            $jobCrawler->filter('tr.underShelfFooter div.heading6.tapItem-gutter ul li')->each(function (Crawler $desCrawler) use ($job) {
                IndeedJobListingDescription::updateOrCreate(['indeed_job_listing_id' => $job->id, 'description' => $desCrawler->text()]);
            });

        });
    }

    /**
     * @return Collection<int,IndeedJobListing>
     */
    public function getJobs(): Collection
    {
        return IndeedJobListing::with(['tags', 'descriptions'])->get();
    }
}
