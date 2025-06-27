<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;
use App\Models\Material;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class MaterialComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $description, $pdf_file, $editId;
    public $showModal = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
    ];

    public function render()
    {
        $materials = Material::where('teacher_id', Auth::id())->latest()->paginate(5);
        return view('livewire.material-component', compact('materials'));
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->showModal = false;
    }

    public function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->pdf_file = null;
        $this->editId = null;
    }

    public function store()
    {
        $this->validate();

        $path = $this->pdf_file ? $this->pdf_file->store('materials', 'public') : null;

        Material::create([
            'teacher_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'pdf_file' => $path ?? '', // kosongkan kalau null
        ]);

        $this->closeModal();
        session()->flash('message', 'Materi berhasil ditambahkan');
        Flux::toast(heading: 'Success', text: 'Data saved successfully', variant: 'success');
    }


    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $this->editId = $material->id;
        $this->title = $material->title;
        $this->description = $material->description;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $material = Material::findOrFail($this->editId);

        $path = $this->pdf_file?->store('materials', 'public') ?? $material->pdf_file;

        $material->update([
            'title' => $this->title,
            'description' => $this->description,
            'pdf_file' => $path,
        ]);

        $this->closeModal();
        session()->flash('message', 'Materi berhasil diperbarui');
    }

    public function delete($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        session()->flash('message', 'Materi berhasil dihapus');
    }
}
