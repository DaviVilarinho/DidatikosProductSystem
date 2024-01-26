<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ __('domain.website_name') }} - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div class="container" id="app">
        @section('navbar')
            <nav class="navbar navbar-expand-lg navbar-expand">
                <div class="collapse navbar-collapse " id="navbarNav">
                    <a class="navbar-brand" href="/">{{ __('domain.website_name') }}</a>
                </div>
            </nav>
        @show



        <div class="content">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
