<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Calculateur de soumission') }}</title>
        @vite(['resources/js/app.js'])
    </head>
    <body>
        <div class="bg-danger d-inline-flex w-100 justify-content-start text-white p-2">
            <h3>{{ config('app.name', 'Calculateur de soumission') }}</h3>
        </div>
        <div id="app" class="bg-light w-100 p-5"></div>
    </body>
</html>
