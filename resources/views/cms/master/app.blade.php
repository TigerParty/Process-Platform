<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="stylesheet" href="{{ mix('/css/cms.css') }}">
    @stack('custom-styles')
</head>

<body>
    @include('cms.includes.header')
    <div class="container h-100">

        <div class="row justify-content-center">
            <div class="local-deployment-message-bar">
                Notice: This site is for testing only and should not be used to submit genuine corruption reports.
            </div>
            <main class="col-12 col-lg-10">
                @if(Route::currentRouteName() == 'admin.step.show')
                {!! Breadcrumbs::render('admin.step.show', $step) !!}
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('custom-scripts')
    <script src="{{ mix('/js/cms.js')}} "></script>
</body>
</html>