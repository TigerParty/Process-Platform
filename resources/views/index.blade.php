<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="uuid" content="{{ Uuid::generate(4) }}">
        <title>{{ env('APP_NAME') }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
        <script>
            window.argoConfig = JSON.parse('@json(config('argo'))');
        </script>
    </head>
    <body>
        <div id="app" class="container-fluid">
            <div class="local-deployment-message-bar">
                Notice: This site is for testing only and should not be used to submit genuine corruption reports.
            </div>
           <router-view></router-view>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
