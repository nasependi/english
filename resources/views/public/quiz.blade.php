<div class="bg-white shadow-xl rounded-lg w-full max-w-2xl p-6 sm:p-8 mx-auto my-10">
	<div class="mb-6 sm:mb-8">
		<div class="flex items-center justify-between mb-2">
			<h2 class="text-slate-900 text-xl sm:text-2xl font-bold tracking-tight">Kuis Bahasa Inggris</h2>
			<div class="text-sm text-slate-600 font-medium">
				Soal <span class="font-bold text-slate-800">{{ $currentIndex }}</span> dari <span class="font-bold text-slate-800">{{ $total }}</span>
			</div>
		</div>
		<div class="w-full bg-slate-200 rounded-full h-2.5">
			<div class="bg-[var(--primary-color)] h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
		</div>
	</div>

	<div class="mb-6">
		@if ($question)
		<p class="text-slate-800 text-base sm:text-lg font-medium leading-relaxed">
			{!! $question->question !!}
		</p>
		@else
		<p class="text-red-500">Soal tidak ditemukan.</p>
		@endif
	</div>


	<div class="space-y-4">
		@if ($question && $question->type === 'pg')
			@php
				$options = [];
				if ($question->options) {
					$decodedOptions = json_decode($question->options, true);
					$options = is_array($decodedOptions) ? $decodedOptions : [];
				}
			@endphp
			
			@if (!empty($options))
				@foreach ($options as $key => $value)
				<label class="flex items-center gap-x-3 p-4 rounded-lg border border-slate-200 hover:border-[var(--primary-color)] transition-all cursor-pointer">
					<input type="radio" wire:model="selectedOption" name="option" value="{{ $key }}" class="h-5 w-5 text-[var(--primary-color)]">
					<span class="text-slate-700 text-base">{{ $value }}</span>
				</label>
				@endforeach
			@else
				<p class="text-red-500 text-sm">Pilihan jawaban tidak tersedia.</p>
			@endif
		@elseif ($question && $question->type === 'essay')
		<textarea wire:model="selectedOption"
			class="w-full rounded-lg border border-slate-300 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)]"
			rows="5" placeholder="Tulis jawabanmu di sini..."></textarea>
		@else
		<p class="text-red-500 text-sm">Tipe soal tidak dikenali.</p>
		@endif
	</div>


	@if (session()->has('message'))
	<div class="mt-4 text-red-500 text-sm">
		{{ session('message') }}
	</div>
	@endif

	<div class="mt-8 flex justify-between items-center">
		<button wire:click="previousQuestion" 
			@if($currentIndex == 1) disabled @endif
			class="flex items-center justify-center gap-2 rounded-lg h-11 px-6 bg-slate-200 text-slate-700 text-sm font-bold hover:bg-slate-300 disabled:opacity-50 disabled:cursor-not-allowed">
			<i class="material-icons text-lg">arrow_back</i>
			<span>Sebelumnya</span>
		</button>

		@if($currentIndex == $total)
		<button wire:click="finishQuiz" class="flex items-center justify-center gap-2 rounded-lg h-11 px-6 bg-green-600 text-white text-sm font-bold hover:bg-green-700">
			<span>Selesai</span>
			<i class="material-icons text-lg">check</i>
		</button>
		@else
		<button wire:click="nextQuestion" class="flex items-center justify-center gap-2 rounded-lg h-11 px-6 bg-[var(--primary-color)] text-white text-sm font-bold hover:bg-blue-600">
			<span>Berikutnya</span>
			<i class="material-icons text-lg">arrow_forward</i>
		</button>
		@endif
	</div>
</div>