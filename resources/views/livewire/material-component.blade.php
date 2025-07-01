<div>
    <flux:card>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Chapter List</h2>
            <flux:button wire:click="openModal" variant="primary">Add Chapter</flux:button>
        </div>

        @if (session()->has('message'))
        <div class="text-green-600 mb-2">{{ session('message') }}</div>
        @endif

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column>File</flux:table.column>
                <flux:table.column>Option</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($materials as $material)
                <flux:table.row :key="$material-> id">
                    <flux:table.cell>{{ $material->title }}</flux:table.cell>
                    <flux:table.cell class="whitespace-normal break-words">
                        {!! $material->description !!}
                    </flux:table.cell>
                    <flux:table.cell>
                        @if ($material->pdf_file)
                        <a href="{{ asset('storage/' . $material->pdf_file) }}" target="_blank" class="text-blue-600 underline">View</a>
                        @else
                        -
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" wire:click="edit({{ $material->id }})">Edit</flux:button>
                        <flux:button size="sm" variant="danger" class="ml-2" wire:click="delete({{ $material->id }})">Delete</flux:button>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        <div class="mt-4">
            {{ $materials->links() }}
        </div>

        <flux:modal class="min-w-[30rem]" wire:model.self="showModal">
            <div class="space-y-4">
                <flux:heading size="lg">{{ $editId ? 'Edit Materi' : 'Tambah Materi' }}</flux:heading>

                <flux:input label="Title" wire:model.defer="title" />
                @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <flux:editor wire:model.defer="description" label="Desriction" />
                @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="file" wire:model="pdf_file" class="block w-full text-sm text-gray-500">
                @error('pdf_file')
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
    </flux:card>
</div>