<div>
    <flux:card class="p-6 space-y-6">
        {{-- Header Quiz --}}
        <h1 class="text-xl font-bold mb-1">{{ $quiz->title }}</h1>
        <p class="text-gray-600 mb-6">Durasi: {{ $quiz->duration }} menit</p>

        {{-- List Soal --}}
        {{-- Soal Pilihan Ganda --}}
        <h2 class="text-lg font-semibold mb-2">Soal Pilihan Ganda</h2>
        <ul class="list-decimal pl-5 mb-6 space-y-3">
            @forelse ($quiz->questions->where('type', 'pg') as $q)
            <li>
                <div class="mb-1 font-small">{{ $q->question }}</div>
                @php
                try {
                $decodedOptions = json_decode($q->options, true);
                $options = is_array($decodedOptions) ? $decodedOptions : [];
                } catch (\Throwable $e) {
                $options = [];
                }
                @endphp
                <ul class="list-none pl-4 space-y-1">
                    @if (!empty($options) && is_array($options))
                    @foreach ($options as $key => $option)
                    <li>
                        <strong
                            @if($q->answer_key === $key)
                            @endif
                            >{{ $key }}.</strong>
                        {{ $option }}

                        @if($q->answer_key === $key)
                        <span class="ml-2 text-sm text-green-600 font-semibold">(Jawaban Benar)</span>
                        @endif
                    </li>
                    @endforeach

                    @else
                    <li class="text-gray-500">Pilihan belum diisi.</li>
                    @endif

                </ul>
            </li>
            @empty
            <li class="text-gray-500">Belum ada soal pilihan ganda.</li>
            @endforelse
        </ul>

        {{-- Soal Essay --}}
        <h2 class="text-lg font-semibold mb-2">Soal Essay</h2>
        <ul class="list-decimal pl-5 mb-6 space-y-3">
            @forelse ($quiz->questions->where('type', 'essay') as $q)
            <li>
                <div class="mb-1 font-small">{{ $q->question }}</div>
                @if (!empty($q->answer_key))
                <div class="text-green-700 text-sm">Jawaban: <span class="font-semibold">{{ $q->answer_key }}</span></div>
                @endif
            </li>
            @empty
            <li class="text-gray-500">Belum ada soal essay.</li>
            @endforelse
        </ul>



        {{-- Tambah Soal --}}
        <h2 class="text-lg font-semibold mb-4">Tambah Soal</h2>

        <form wire:submit.prevent="saveQuestions" class="space-y-6">
            @foreach ($questionInputs as $index => $input)
            <flux:card class="space-y-4 p-4" wire:key="question-{{ $index }}">
                {{-- Pertanyaan --}}
                <flux:input
                    label="Pertanyaan"
                    wire:model.defer="questionInputs.{{ $index }}.question" />

                {{-- Tipe Soal --}}
                <flux:select
                    label="Tipe Soal"
                    wire:model.live="questionInputs.{{ $index }}.type">
                    <flux:select.option value="pg">Pilihan Ganda</flux:select.option>
                    <flux:select.option value="essay">Essay</flux:select.option>
                </flux:select>

                {{-- Pilihan Ganda --}}
                @if ($questionInputs[$index]['type'] === 'pg')
                <div class="space-y-2">
                    <p class="font-medium">Opsi Jawaban</p>
                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                    <div class="flex items-center gap-2">
                        <span class="w-6 font-semibold">{{ $opt }}</span>
                        <flux:input
                            wire:model.defer="questionInputs.{{ $index }}.options.{{ $opt }}"
                            placeholder="Opsi {{ $opt }}" />
                    </div>
                    @endforeach

                    <flux:input
                        label="Kunci Jawaban (A/B/C/D)"
                        wire:model.defer="questionInputs.{{ $index }}.answer_key"
                        maxlength="1"
                        class="mt-1 w-24" />
                </div>
                @endif

                {{-- Essay --}}
                @if ($questionInputs[$index]['type'] === 'essay')
                <flux:textarea
                    label="Kunci Jawaban Essay (Opsional)"
                    wire:model.defer="questionInputs.{{ $index }}.answer_key"
                    rows="2" />
                @endif

                {{-- Tombol Hapus Section --}}
                <div class="text-right">
                    <flux:button
                        variant="primary"
                        size="sm"
                        wire:click="removeQuestion({{ $index }})">
                        Hapus Soal Ini
                    </flux:button>
                </div>
            </flux:card>
            @endforeach

            {{-- Tombol Aksi --}}
            <div class="flex justify-between mt-4">
                <flux:button type="button" variant="outline" wire:click="addQuestion">
                    + Tambah Section Soal
                </flux:button>

                <flux:button type="submit" variant="primary">
                    Simpan Semua
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>