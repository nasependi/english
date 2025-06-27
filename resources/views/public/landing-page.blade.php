@extends('layout.app')

@section('title', 'Home')

@section('content')
<html>

<head>
    <meta charset="utf-8" />
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Lexend%3Awght%40300%3B400%3B500%3B600%3B700&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style type="text/tailwindcss">
        :root {
        --primary-color: #3d98f4;
        --text-primary: #111418;
        --text-secondary: #60758a;
        --bg-light: #f0f2f5;
        --bg-white: #ffffff;
        --border-light: #e5e7eb;}
      body {
        font-family: 'Lexend', 'Noto Sans', sans-serif;
      }
      .hero-gradient {
        background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.6)), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDmNTM6tsK7LaiRk0NHcUxJ3QebYLUIajdk_FzETkNyxEPHnNmT6ZeFd7fyHcoHBJ4i2SayAYxQ7ASMLfmLlQPWGGEIuQB1Jy7PetiAC6hCf-I9P9Gfzul2WadiFpOEpyvKZZ6U8ySsW1cyo4uYb88Bb4Jebq6hPh_FIGlsM3mpQLTV0FnPhHkJEaGmpG1qyWpuFvt4xx_Z45Joj245azG30JydhzVyuuqccPJvlGz5AxCAtuMFa74SAPOs5DqgUXEJmiSmO4ME_DJY");
      }
      * .nav-link-active {
            color: var(--primary-color);
            font-weight: 700;
            border-bottom: 2px solid var(--primary-color);
        }
    </style>
</head>

<body class="bg-[var(--bg-white)] text-[var(--text-primary)]">
    <div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
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
                    <a class="nav-link-active text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors"
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
            <main class="flex flex-1 flex-col items-center">
                <section class="w-full">
                    <div class="relative hero-gradient bg-cover bg-center bg-no-repeat">
                        <div class="absolute inset-0 bg-black/50"></div>
                        <div class="relative mx-auto max-w-screen-xl px-4 py-24 sm:py-32 lg:py-48 text-center text-white">
                            <h1 class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl drop-shadow-md">
                                Selamat Datang di <span class="text-[var(--primary-color)]">EnglishApp</span>
                            </h1>
                            <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl leading-relaxed drop-shadow-sm">
                                Tingkatkan kemampuan bahasa Inggris Anda dengan materi yang interaktif yang dirancang khusus untuk siswa kelas 10. Mulai belajar dengan cara yang menyenangkan dan
                                efektif!
                            </p>
                            <div class="mt-10">
                                <button class="flex min-w-[150px] max-w-[480px] mx-auto cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-6 sm:h-14 sm:px-8 bg-[var(--primary-color)] hover:bg-blue-600 text-white text-base sm:text-lg font-bold leading-normal tracking-wide shadow-lg transition-transform duration-150 ease-in-out hover:scale-105">
                                    <span class="truncate">Mulai belajar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="w-full py-16 sm:py-24 bg-[var(--bg-light)]">
                    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-bold text-center text-[var(--text-primary)] mb-12">Mengapa Memilih EnglishApp?</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                            <div class="bg-[var(--bg-white)] p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex justify-center mb-4">
                                    <svg class="w-16 h-16 text-[var(--primary-color)]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-2">Kuis Interaktif</h3>
                                <p class="text-[var(--text-secondary)] text-sm leading-relaxed">Soal-soal yang menarik dan menantang untuk menguji pemahaman Anda.</p>
                            </div>
                            <div class="bg-[var(--bg-white)] p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex justify-center mb-4">
                                    <svg class="w-16 h-16 text-[var(--primary-color)]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-2">Materi Relevan</h3>
                                <p class="text-[var(--text-secondary)] text-sm leading-relaxed">Sesuai dengan kurikulum bahasa Inggris kelas 10 terbaru.</p>
                            </div>
                            <div class="bg-[var(--bg-white)] p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex justify-center mb-4">
                                    <svg class="w-16 h-16 text-[var(--primary-color)]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-2">Belajar Efektif</h3>
                                <p class="text-[var(--text-secondary)] text-sm leading-relaxed">Tingkatkan nilai dan kepercayaan diri dalam berbahasa Inggris.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <footer class="bg-slate-50 border-t py-6 text-center text-sm text-[var(--text-secondary)]">
                © {{ date('Y') }} EnglishApp.
            </footer>
        </div>
    </div>

</body>

</html>

@endsection