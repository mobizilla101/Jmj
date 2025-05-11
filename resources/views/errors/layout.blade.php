<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.png" type="image/png">

        <title>{{config('app.name')}} @yield('title')</title>


    </head>
    <body class="grid content-center min-h-screen">
        <div class="flex-center position-ref full-height">

                    <img src="{{asset('assets/images/logo.png')}}" class="h-44 w-44 mb-12 animate-bounce" alt="Mobizilla"/>

            <div class=" flex">
                    @yield('message')
            </div>


                </div>

    </body>
</html>
