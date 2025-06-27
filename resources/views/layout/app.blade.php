<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EduQuest')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') {{-- Kalau kamu pakai Vite --}}
    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen">
        {{-- Navbar bisa disini --}}
        @yield('content')
    </div>

    @livewireScripts
</body>

</html>