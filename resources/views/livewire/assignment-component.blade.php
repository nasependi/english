<div>
    <flux:card>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">List Task</h2>
            <flux:button wire:click="openModal" variant="primary">Create Task</flux:button>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column>Deadline</flux:table.column>
                <flux:table.column>Chapter</flux:table.column>
                <flux:table.column>Option</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($assignments as $assignment)
                <flux:table.row :key="$assignment->id">
                    <flux:table.cell>{{ $assignment->title }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal break-words">
                        {!!$assignment->description !!}
                    </flux:table.cell>
                    <flux:table.cell>{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y H:i') }}</flux:table.cell>
                    <flux:table.cell>
                        {{ $assignment->material ? $assignment->material->title : 'N/A' }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" wire:click="edit({{ $assignment->id }})">Edit</flux:button>

                        <flux:modal.trigger name="confirm-delete">
                            <flux:button size="sm" variant="danger" class="ml-2" wire:click="confirmDelete({{ $assignment->id }})">Delete</flux:button>
                        </flux:modal.trigger>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        <div class="mt-4">
            {{ $assignments->links() }}
        </div>

        {{-- Modal Form Tambah / Edit --}}
        <flux:modal class="min-w-[30rem]" wire:model.self="showModal">
            <div class="space-y-4">
                <flux:heading size="lg">{{ $editId ? 'Edit Tugas' : 'Tambah Tugas' }}</flux:heading>

                <flux:input label="Title" wire:model.defer="title" />
                @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <flux:editor wire:model.defer="description" label="Desriction" />
                @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <flux:input label="Deadline" type="datetime-local" wire:model.defer="deadline" />
                @error('deadline')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <flux:select wire:model.defer="material_id" label="Chapter" placeholder="Choose chapter..." required>
                    <flux:select.option value="">-- Pilih Materi --</flux:select.option>
                    @foreach ($chapters as $chapter)
                    <flux:select.option value="{{ $chapter->id }}">{{ $chapter->title }}</flux:select.option>
                    @endforeach
                </flux:select>
                @error('material_id')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

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

        {{-- Modal Konfirmasi Hapus --}}
        <flux:modal name="confirm-delete" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete task?</flux:heading>
                    <flux:text class="mt-2">
                        <p>You will delete this task permanently</p>
                        <p>This action cannot be undone.</p>
                    </flux:text>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>

                    <flux:button type="button" variant="danger" wire:click="delete">Save</flux:button>
                </div>
            </div>
        </flux:modal>
    </flux:card>
</div>