<div>
    <flux:card>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Submission List</h2>
            <flux:button wire:click="openModal" variant="primary">Add Submission</flux:button>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Assignment</flux:table.column>
                <flux:table.column>Answer</flux:table.column>
                <flux:table.column>File</flux:table.column>
                <flux:table.column>Submitted At</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($submissions as $submission)
                <flux:table.row :key="$submission->id">
                    <flux:table.cell>{{ $submission->assignment->title }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal break-words">
                        {!! $submission->answer_text !!}
                    </flux:table.cell>
                    <flux:table.cell>
                        @if ($submission->pdf_file)
                        <a href="{{ asset('storage/' . $submission->pdf_file) }}" target="_blank" class="text-blue-600 underline">View</a>
                        @else
                        -
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>{{ $submission->submitted_at }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" wire:click="edit({{ $submission->id }})">Edit</flux:button>
                        <flux:modal.trigger name="confirm-delete">
                            <flux:button size="sm" variant="danger" class="ml-2" wire:click="confirmDelete({{ $submission->id }})">Delete</flux:button>
                        </flux:modal.trigger>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        <div class="mt-4">
            {{ $submissions->links() }}
        </div>

        {{-- Modal Input --}}
        <flux:modal class="min-w-[30rem]" wire:model.self="showModal">
            <div class="space-y-4">
                <flux:heading size="lg">{{ $editId ? 'Edit Submission' : 'New Submission' }}</flux:heading>

                <flux:autocomplete
                    wire:model="assignmentTitle"
                    label="Select Assignment"
                    placeholder="Type to search...">

                    @foreach ($assignments as $assignment)
                    <flux:autocomplete.item
                        wire:click="$set('selectedAssignmentId', {{ $assignment->id }})">
                        {{ $assignment->title }}
                    </flux:autocomplete.item>
                    @endforeach
                </flux:autocomplete>
                @error('selectedAssignmentId')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror


                <flux:editor wire:model.defer="answer_text" label="Answer Text" />
                @error('answer_text') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <input type="file" wire:model="pdf_file" class="block w-full text-sm text-gray-500">
                @error('pdf_file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <flux:input type="datetime-local" label="Submitted At" wire:model.defer="submitted_at" />
                @error('submitted_at') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror


                <div class="flex justify-end space-x-2">
                    <flux:button class="bg-gray-300" wire:click="closeModal">Cancel</flux:button>
                    <flux:button variant="primary" wire:click="{{ $editId ? 'update' : 'store' }}">
                        {{ $editId ? 'Update' : 'Submit' }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>

        {{-- Modal Delete --}}
        <flux:modal name="confirm-delete" class="min-w-[22rem]">
            <div class="space-y-6">
                <flux:heading size="lg">Delete Submission?</flux:heading>
                <flux:text>This action cannot be reversed.</flux:text>

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button wire:click="delete" variant="danger">Delete</flux:button>
                </div>
            </div>
        </flux:modal>
    </flux:card>
</div>