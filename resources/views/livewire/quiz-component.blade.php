<div>
    <flux:card>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">List Quiz</h2>
            <flux:button wire:click="openModal" variant="primary">Create Quiz</flux:button>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Duration (minutes)</flux:table.column>
                <flux:table.column>Total Questions</flux:table.column>
                <flux:table.column>Options</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($quizzes as $quiz)
                <flux:table.row :key="$quiz->id">
                    <flux:table.cell>{{ $quiz->title }}</flux:table.cell>
                    <flux:table.cell>{{ $quiz->duration }}</flux:table.cell>
                    <flux:table.cell>{{ $quiz->questions_count }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="space-x-1.5">
                            <flux:link href="/quiz/{{ $quiz->id }}">
                                <flux:button size="sm">Detail</flux:button>
                            </flux:link>
                            <flux:button size="sm" wire:click="edit({{ $quiz->id }})">Edit</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="delete({{ $quiz->id }})">Delete</flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        <div class="mt-4">
            {{ $quizzes->links() }}
        </div>

        {{-- Modal Create/Edit --}}
        <flux:modal class="min-w-[30rem]" wire:model.self="showModal">
            <div class="space-y-4">
                <flux:heading size="lg">{{ $editId ? 'Edit Quiz' : 'Create Quiz' }}</flux:heading>

                <flux:input label="Title" wire:model.defer="title" />
                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <flux:input label="Duration (minutes)" type="number" wire:model.defer="duration" />
                @error('duration') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

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