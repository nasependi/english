@extends('layout.app')

@section('title', $chapter->title)

@section('content')
<main class="px-10 sm:px-20 md:px-40 flex flex-1 justify-center py-8 bg-slate-50">
	<div class="layout-content-container flex flex-col max-w-4xl flex-1 bg-white p-8 rounded-lg shadow-lg">
		<nav aria-label="Breadcrumb" class="mb-6">
			<ol class="flex flex-wrap items-center gap-2 text-sm">
				<li>
					<a class="text-[var(--text-secondary)] hover:text-[var(--primary-color)] transition-colors duration-150 font-medium" href="#">Kelas 10</a>
				</li>
				<li><span class="text-[var(--text-secondary)]">/</span></li>
				<li>
					<a class="text-[var(--text-secondary)] hover:text-[var(--primary-color)] transition-colors duration-150 font-medium" href="#">Bahasa Inggris</a>
				</li>
			</ol>
		</nav>

		<article>
			<h2 class="text-[var(--text-primary)] tracking-tight text-3xl font-bold leading-tight mb-6">
				{{ $chapter->title }}
			</h2>
			<p class="text-[var(--text-primary)] text-base font-normal leading-relaxed mb-6">
				{{ $chapter->description }}
			</p>



			{{-- Tambahan jika ada struktur data lain, misal materi detail atau file --}}
		</article>

		<div class="flex justify-end mt-8">
			<a href="{{ route('quiz') }}">
				<button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-[var(--primary-color)] text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-blue-600 transition-colors duration-150 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
					<span class="truncate">Assignment</span>
					<svg class="ml-2" fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
						<path d="M224.49,136.49l-72,72a12,12,0,0,1-17-17L187,140H40a12,12,0,0,1,0-24H187L135.51,64.48a12,12,0,0,1,17-17l72,72A12,12,0,0,1,224.49,136.49Z" />
					</svg>
				</button>
			</a>
		</div>
	</div>
</main>
@endsection