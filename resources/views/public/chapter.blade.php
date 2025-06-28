@extends('layout.app')

@section('title', 'Chapter')

@section('content')
<div class="p-4 sm:p-6">
	<main class="flex justify-center">
		<div class="w-full max-w-6xl">
			<div class="mb-10">
				<h1 class="text-3xl sm:text-4xl font-bold text-[var(--text-primary)] leading-tight">
					Materi Bahasa Inggris Kelas 10
				</h1>
				<p class="mt-2 text-base sm:text-lg text-[var(--text-secondary)]">
					Pilih bab untuk memulai pembelajaran Anda.
				</p>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
				@forelse ($chapters as $chapter)
				<a href="{{ route('description', ['id' => $chapter->id]) }}"
					class="group bg-[var(--background-light)] rounded-xl shadow hover:shadow-md transition duration-300 overflow-hidden">

					<div class="p-6">
						<div class="flex items-start mb-4">
							<div class="flex items-center justify-center size-12 rounded-lg bg-blue-100 text-[var(--primary-color)] mr-4">
								<span class="material-icons text-3xl">auto_stories</span>
							</div>
							<div class="flex-1">
								<h2 class="text-lg font-semibold text-[var(--text-primary)] group-hover:text-[var(--primary-color)] transition">
									{{ $chapter->title }}
								</h2>
								<p class="text-sm text-[var(--text-secondary)]">
									{{ $chapter->subtitle ?? 'Chapter ' . $chapter->id }}
								</p>
							</div>
						</div>

						<p class="text-sm text-[var(--text-secondary)] leading-relaxed line-clamp-3">
							Deskripsi: {{ $chapter->description }}
						</p>

						<div class="mt-4 text-right">
							<span class="inline-flex items-center text-sm font-medium text-[var(--primary-color)] group-hover:underline">
								Lihat Materi
								<span class="material-icons text-base ml-1">arrow_forward</span>
							</span>
						</div>
					</div>
				</a>
				@empty
				<div class="col-span-full text-center text-gray-500">
					Belum ada chapter yang tersedia.
				</div>
				@endforelse
			</div>
		</div>
	</main>
</div>
@endsection