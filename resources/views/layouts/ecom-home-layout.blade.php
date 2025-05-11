 <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.png" type="image/png">

    <!-- Dynamic Title -->
    <title>
        {{ config('app.name') }}{{ isset($title) ? ' | ' . $title : '' }}
    </title>

    <!-- Meta Tags -->
    <meta name="description" content="{{ $metaDescription ?? config('seo.description') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? config('seo.keywords') }}">
    <meta name="author" content="{{ $metaAuthor ?? config('seo.author') }}">
    <meta name="robots" content="{{ $metaRobots ?? config('seo.robots') }}">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ config('app.name') }}{{ isset($title) ? ' | ' . $title : '' }}">
    <meta property="og:description" content="{{ $metaDescription ?? config('seo.og.description') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="{{ config('seo.og.type') }}">
    <meta property="og:image" content="{{ $metaImage ?? asset(config('seo.og.image')) }}">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="{{ config('seo.twitter.card') }}">
    <meta name="twitter:title" content="{{ config('app.name') }}{{ isset($title) ? ' | ' . $title : '' }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? config('seo.og.description') }}">
    <meta name="twitter:image" content="{{ $metaImage ?? asset(config('seo.twitter.image')) }}">

    <!-- Styles -->
    @vite('resources/scss/app.scss')
    @stack('styles')
    @livewireStyles
</head>
<body class="grid grid-rows-[auto_1fr_auto] min-h-screen">
<x-partials._navbar/>
{{ $slot }}
<x-partials._footer/>
@livewireScripts
@stack('models')
@stack('js')
@vite('resources/js/app.js')
</body>
</html>
