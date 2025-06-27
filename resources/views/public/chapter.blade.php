@extends('layout.app')

@section('title', 'Chapter')

@section('content')
<div class="p-1">
	<main class="flex flex-1 justify-center">
		<div class="layout-content-container flex flex-col w-full max-w-4xl">
			<div class="mb-8 p-4">
				<h2 class="text-[var(--text-primary)] tracking-tight text-3xl sm:text-4xl font-bold leading-tight">Materi Bahasa Inggris Kelas 10</h2>
				<p class="text-[var(--text-secondary)] mt-2 text-base sm:text-lg">Pilih bab untuk memulai pembelajaran Anda.</p>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				@foreach ($chapters as $chapter)
				<a href="{{ route('description', ['id' => $chapter->id]) }}" class="chapter-card bg-[var(--background-light)] rounded-xl shadow-lg overflow-hidden transition-all duration-300 ease-in-out group">
					<div class="p-6">
						<div class="flex items-center mb-4">
							<div class="text-[var(--primary-color)] flex items-center justify-center rounded-lg bg-blue-100 shrink-0 size-12 mr-4">
								<span class="material-icons text-3xl">auto_stories</span>
							</div>
							<div>
								<h3 class="text-[var(--text-primary)] text-lg font-semibold leading-tight group-hover:text-[var(--primary-color)] transition-colors">
									{{ $chapter->title }}
								</h3>
								<p class="text-[var(--text-secondary)] text-sm font-normal">
									{{ $chapter->subtitle ?? 'Chapter ' . $chapter->id }}
								</p>
							</div>
						</div>
						<p class="text-[var(--text-secondary)] text-sm font-normal leading-relaxed line-clamp-3">
							Deskripsi: {{ $chapter->description }}
						</p>
						<div class="mt-4 text-right">
							<span class="text-[var(--primary-color)] text-sm font-medium group-hover:underline">
								Lihat Materi
								<span class="material-icons text-sm align-middle">arrow_forward</span>
							</span>
						</div>
					</div>
				</a>
				@endforeach
			</div>

		</div>
	</main>
</div>
@endsection