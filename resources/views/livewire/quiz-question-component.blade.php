<div>
    <flux:card>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Question List</h2>
            <flux:button wire:click="openModal" variant="primary">Add Question</flux:button>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>#</flux:table.column>
                <flux:table.column>Question</flux:table.column>
                <flux:table.column>Type</flux:table.column>
                <flux:table.column>Answer Key</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($questions as $index => $q)
                <flux:table.row :key="$q->id">
                    <flux:table.cell>{{ $index + 1 }}</flux:table.cell>
                    <flux:table.cell class="whitespace-pre-wrap">{{ $q->question }}</flux:table.cell>
                    <flux:table.cell class="uppercase">{{ $q->type }}</flux:table.cell>
                    <flux:table.cell>
                        @if ($q->type === 'pg')
                        {{ json_decode($q->answer_key) }}
                        @else
                        {{ $q->answer_key }}
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" wire:click="edit({{ $q->id }})">Edit</flux:button>
                        <flux:button size="sm" variant="danger" class="ml-2" wire:click="delete({{ $q->id }})">Delete</flux:button>
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center">No questions available.</flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Modal --}}
        <flux:modal class="min-w-[40rem]" wire:model.self="showModal">
            <div class="space-y-4">
                <flux:heading size="lg">{{ $editId ? 'Edit' : 'Add' }} Question</flux:heading>

                <flux:textarea label="Question" wire:model.defer="question" />
                @error('question') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <flux:select wire:model="type" label="Question Type">
                    <flux:select.option value="pg">Multiple Choice</flux:select.option>
                    <flux:select.option value="essay">Essay</flux:select.option>
                </flux:select>

                @if ($type === 'pg')
                <div class="space-y-2">
                    <p class="font-medium">Options</p>
                    @foreach(['A', 'B', 'C', 'D'] as $opt)
                    <div class="flex items-center gap-2">
                        <span class="w-6 font-bold">{{ $opt }}</span>
                        <flux:input wire:model.defer="options.{{ $opt }}" placeholder="Option {{ $opt }}" />
                    </div>
                    @endforeach

                    <flux:input label="Correct Answer (A/B/C/D)" wire:model.defer="answer_key" maxlength="1" />
                    @error('answer_key') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif

                @if ($type === 'essay')
                <flux:textarea label="Essay Answer Key (Optional)" wire:model.defer="answer_key" />
                @endif

                <div class="flex justify-end space-x-2">
                    <flux:button class="bg-gray-300" wire:click="closeModal">Cancel</flux:button>
                    @if ($editId)
                    <flux:button variant="primary" wire:click="update">Update</flux:button>
                    @else
                    <flux:button variant="primary" wire:click="store">Save</flux:button>
                    @endif
                </div>
            </div>
        </flux:modal>
    </flux:card>
</div>