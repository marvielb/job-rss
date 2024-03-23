<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>
</head>

<body class="flex w-full justify-center">
    <div class="max-w-screen-md ">
        @foreach ($jobs as $job)
            <a href="https://www.onlinejobs.ph{{ $job->posting_link }}" target=”_blank”
                class="card  bg-neutral text-neutral-content mt-5 cursor-pointer hover:shadow-lg">
                <div class="card-body ">
                    <h2 class="card-title">{{ $job->title }}</h2>
                    <span>{{ $job->employer }} | {{ $job->formatted_posting_date }}</span>
                    <span>{{ $job->salary }}</span>
                    <p class="pt-5">
                        {{ $job->description }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</body>

</html>
