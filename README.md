# Job RSS

Job RSS is a job aggregator that allows you to easily find and view job listings. It supports multiple sources,
currently [OnlineJobs Ph](https://www.onlinejobs.ph/) and [Indeed](https://ph.indeed.com/). Currently on the
initial stage and will be improved in the future. The main goal is to learn more in depth Laravel features
like [queues](https://laravel.com/docs/11.x/queues) and general website scraping techniques.

## Features

-   List all of the latest job listings from multiple sources
-   Get job listings from OnlineJobs Ph
-   Get job listings from Indeed

## Technologies Used

-   PHP
-   Laravel
-   Docker
-   <s>Postgres</s> Sqlite
-   Tailwind
-   Bun
-   Selenium
-   Nix

## Installation

For this, you have to have docker installed for convenience. Also, php for running the sail commands. On that
note, you have to install the `sail` command.

1. Pull this repo
2. Copy the .env.example to .env
3. Run `php artisan key:generate`

## Running Locally

1. Run `sail up -d` to start the server.
2. Run `sail bun dev` for the assets.
3. Run `sail artisan queue:work` to run the laravel worker.
4. Run `sail artisan app:scrape` to start the scraping process.

## Known Issues

-   No coherent sorting as Indeed does not provide posting date

## TODO

-   [x] Integrate AI to evaluate if the job listing is compatible with the user
-   [ ] AI generated cover letter for the job listing
-   [ ] AI generated sample script for the interview of job listing
-   [ ] AI generated custom resume for a job listing

## Deployment

You must have a configured server with nginx + php-fpm setup.

-   Run `nix develop` to load the proper php version
-   Run `./vendor/bin/dep deploy` to deploy the project.
-   If first time to setup, do the following:
    -   Setup .env file in the server so that deployer will not complain, just add a line `APP_DUMMY_ENV=`
    -   Run `php artisan migrate` because delopyer will perform it when the .env file is not set on the server
    -   Run `php artisan passport:keys` to setup the keys used for Laravel passport
    -   Run `php artisan passport:client --client` to setup the Client OAuth flow for the microservices authentication.
    -   Set the Client ID and Secret in the rater microservice.
