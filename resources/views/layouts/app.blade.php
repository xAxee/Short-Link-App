<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AxShortLink - Skróć link</title>
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
        <script src="https://kit.fontawesome.com/fa409bfd1c.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
        @vite('resources/css/app.css')
        @yield('style')

    </head>
    <body class="bg-gray-900">
        <div class="container mx-auto px-4 text-center">

            @include("partials.nav")

            @yield("content")
        </div>
    </body>
</html>

@yield('script')
