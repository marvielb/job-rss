<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>
</head>

<body class="flex w-full justify-center">
    <div class="max-w-screen-md p-5">
        @foreach ($jobs as $job)
            @if ($job->platform == 'online_jobs_ph' && $job->rating)
                <a href="https://www.onlinejobs.ph{{ $job->posting_link }}" target=”_blank”
                    class="card  bg-neutral text-neutral-content mt-5 cursor-pointer hover:shadow-lg">
                    <div class="card-body ">
                        <div class="flex justify-between">
                            <h2 class="card-title flex-grow">{{ $job->title }}</h2>
                            <span>{{ $job->rating }}%</span>
                        </div>
                        <span>{{ $job->employer }} | {{ $job->formatted_posting_date }}</span>
                        <span>{{ $job->salary }}</span>
                        <p class="pt-5">
                            {{ $job->short_description }}
                        </p>
                    </div>
                </a>
            @endif
            @if ($job->platform == 'indeed')
                <a href="https://ph.indeed.com{{ $job->posting_link }}" target=”_blank”
                    class="card  bg-neutral text-neutral-content mt-5 cursor-pointer hover:shadow-lg">
                    <div class="card-body ">
                        <h2 class="card-title">{{ $job->title }}</h2>
                        <span>{{ $job->employer }} | {{ $job->formatted_posting_date }} | {{ $job->location }}</span>
                        <span>
                            @foreach ($job->tags as $i => $tag)
                                {{ $i != 0 ? '|' : '' }} {{ $tag->tag }}
                            @endforeach
                        </span>
                        <ul class="list-disc ml-5">
                            @foreach ($job->descriptions as $description)
                                <li>{{ $description->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</body>

</html>
