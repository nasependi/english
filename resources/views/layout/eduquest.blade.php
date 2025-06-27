<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'EnglishApp' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        :root {
            --primary-color: #3d98f4;
            --secondary-color: #111418;
            --accent-color: #f0f2f5;
            --text-primary: #111418;
            --text-secondary: #60758a;
            --background-light: #ffffff;
            --background-muted: #f9fafb;
        }

        /* .nav-link-active {
            color: var(--primary-color);
            font-weight: 700;
            border-bottom: 2px solid var(--primary-color);
        }

        .chapter-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        } */
    </style>
</head>

<body class="bg-[var(--background-muted)]" style="font-family: Lexend, 'Noto Sans', sans-serif;">
    <div class="min-h-screen flex flex-col">

        {{-- Header --}}
        <header class="flex items-center justify-between border-b bg-white px-6 py-4 shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="text-[var(--primary-color)]" xmlns="http://www.w3.org/2000/svg" height="32" width="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.084a1 1 0 0 0 0 1.838l8.57 3.908a2 2 0 0 0 1.66 0l8.59-3.908Z" />
                    <path d="M6 12v4c0 4.556 3.076 8 7 8s7-3.444 7-8v-4" />
                </svg>
                <h1 class="text-xl font-bold text-slate-900">EnglishApp</h1>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors"
                    href="{{ route('home') }}">Home</a>

                <a class="text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors"
                    href="{{ route('chapter') }}">Chapter</a>

                <a class="text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors"
                    href="{{ route('quiz.public') }}">Quiz</a>

                <a class="text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors"
                    href="{{ route('score') }}">Score</a> {{-- jika route score sudah ada --}}
            </nav>
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal">
                        Dashboard
                    </a>
                    @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal">
                        Log in
                    </a>
                    @endauth
                </nav>
                @endif
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-slate-50 border-t py-6 text-center text-sm text-[var(--text-secondary)]">
            © {{ date('Y') }} EnglishApp.
        </footer>
    </div>

    @livewireScripts
</body>

</html>