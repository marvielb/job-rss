<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>
</head>

<body class=" flex w-full justify-center">
    <div class="max-w-screen-md">
        <div class="card  bg-neutral text-neutral-content">
            <div class="card-body ">
                <h2 class="card-title">Fullstack Developer</h2>
                <span>Company Name Here | March 12, 2024</span>
                <span>PHP 80,0000</span>
                <p class="pt-5">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Fusce nibh leo, cursus et convallis eget, consequat non nisl.
                    Sed sed placerat sem. Vestibulum nisl libero, dapibus in
                    lacus blandit, eleifend sollicitudin magna.
                </p>
            </div>
        </div>
    </div>

</body>

</html>
