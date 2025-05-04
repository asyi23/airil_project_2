<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo-mobile.png')}}">
        @include('layouts.head')
    </head>
    <body>
        <section class="bg-white error-404-section">
            <div class="error-404-notice-container">
                <div class="error-404-title-container">
                    <span class="error-404-title">@yield('code')</span>
                </div>
                <span class="error-404-caption d-block">@yield('message')</span>
                <a class="btn error-404-redirect" href="/">Back to Home</a>
            </div>
            <div class="error-404-img-container">
                <img src="{{ URL::asset('assets/images/404/404.png') }}">
            </div>
        </section>
    </body>
</html>
