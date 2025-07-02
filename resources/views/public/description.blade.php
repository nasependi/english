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
				{!! $chapter->title !!}
			</h2>
			<p class="text-[var(--text-primary)] text-base font-normal leading-relaxed mb-6">
				{!! $chapter->description !!}
			</p>

			<div class="flex justify-between mt-8 items-center">
				{{-- Tombol Materi (lihat file PDF) --}}
				{{-- Tombol Materi (lihat file PDF) --}}
				@if ($chapter->pdf_file)
				<a href="{{ asset('storage/' . $chapter->pdf_file) }}" target="_blank" class="inline-block">
					<button class="flex items-center justify-center h-12 px-6 bg-slate-500 text-white text-base font-bold rounded-lg hover:bg-slate-600 transition-colors duration-150 shadow-md">
						<span>Lihat Materi</span>
						<svg class="ml-2" fill="currentColor" height="20" width="20" viewBox="0 0 24 24">
							<path d="M5 20h14v-2H5v2zm7-18l-7 7h4v6h6v-6h4l-7-7z" />
						</svg>
					</button>
				</a>
				@endif

				{{-- Tombol Assignment selalu aktif --}}
				<a href="{{ route('assignment.chapter', $chapter->id) }}">
					<button class="flex min-w-[84px] max-w-[480px] items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-slate-500 text-white text-base font-bold transition-colors duration-150 shadow-md hover:bg-slate-600">
						<span class="truncate">Assignment</span>
						<svg class="ml-2" fill="currentColor" height="20" viewBox="0 0 256 256" width="20">
							<path d="M224.49,136.49l-72,72a12,12,0,0,1-17-17L187,140H40a12,12,0,0,1,0-24H187L135.51,64.48a12,12,0,0,1,17-17l72,72A12,12,0,0,1,224.49,136.49Z" />
						</svg>
					</button>
				</a>
			</div>


			{{-- Tambahan jika ada struktur data lain, misal materi detail atau file --}}
		</article>

	</div>
</main>
@endsection

@push('scripts')
<script>
	function markPdfAsViewed() {
		setTimeout(() => {
			const link = document.getElementById('assignment-link');
			if (link) {
				link.classList.remove('pointer-events-none', 'opacity-50');
				const btn = link.querySelector('button');
				btn.classList.remove('cursor-not-allowed', 'bg-gray-400');
				btn.classList.add('bg-[var(--primary-color)]', 'hover:bg-blue-600');
			}
		}, 5000); // misal setelah 5 detik dianggap sudah baca
	}
</script>
@endpush