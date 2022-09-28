<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Lowphashion') }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>

    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
            <div class="mt-2 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-1">
                    <div class="p-6">
                        <div class="mt-2">
                            <img src="@/resources/images/logo.png" alt="Lowphasion Logo" class="w-80" />
                            <div class="flex items-top justify-around">
                                <a href="{{ route('login') }}" class="text-blue-100">Log in</a>
                                <a href="{{ route('register') }}" class="text-blue-100">Sign up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



