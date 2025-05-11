<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.png" type="image/png">

    <title>{{config('app.name')}} | @yield('title')</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="flex items-center flex-col justify-center bg-gradient-to-r to-green-300 from-blue-300 min-h-screen">
<img src="{{asset('assets/images/logo.png')}}" class="h-44 w-44 mb-6 animate-bounce" alt="Mobizilla"/>
<div class=" flex antialiased ">

    <div class="px-4 text-3xl font-semibold text-[#0999D5] border-r border-gray-400 tracking-wider">
        @yield('code')
    </div>

    <div class="ml-4 text-3xl font-semibold text-[#009E56] uppercase tracking-wider">
        @yield('message')
    </div>
</div>
</body>
</html>
