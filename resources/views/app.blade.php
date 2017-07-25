<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('/css/all.css') }}" type="text/css">
    {{--<link rel="stylesheet" href="{{ secure_asset('/css/all.css') }}" type="text/css">--}}
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
<div id="app" class="container-fluid">
    @verbatim
        <app-menu></app-menu>
        <router-view></router-view>
    @endverbatim
</div>
</body>
<script src="{{ asset('/js/app.js') }}"></script>
{{--<script src="{{ secure_asset('/js/app.js') }}"></script>--}}
</html>