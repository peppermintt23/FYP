<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#050e1a] text-white">
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-[#050e1a]">
            <!--box-->
            <div class="bg-[#101b2a] neon-frame w-full max-w-md mx-auto p-10 rounded-2xl shadow-lg">
                {{ $slot }}
            </div>
        </div>

        <style>
        .neon-frame {
            background: rgba(10, 10, 30, 0.97);
            border: 3px solid #15f7fc;
            border-radius: 22px;
            box-shadow: 0 0 24px 5px #15f7fc, 0 0 44px 1px #00bfff85 inset, 0 0 0 9px #061928;
            position: relative;
            overflow: hidden;
        }
        </style>
    </body>
</html>
