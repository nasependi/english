<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;
use App\Models\Assignment;
use App\Models\Material;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AssignmentComponent extends Component
{
    use WithPagination;

    public $title, $description, $deadline, $material_id, $editId;
    public $showModal = false;
    public $confirmingDelete = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'deadline' => 'required|date',
        'material_id' => 'required|exists:material,id',
    ];

    public function render()
    {
        $chapters = Material::get();
        $assignments = Assignment::with('material')->where('teacher_id', Auth::id())->latest()->paginate(5);
        return view('livewire.assignment-component', compact('assignments', 'chapters'));
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
        $this->deadline = '';
        $this->material_id = null;
        $this->editId = null;
    }

    public function store()
    {
        $this->validate();

        Assignment::create([
            'teacher_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'material_id' => $this->material_id,
        ]);

        Flux::toast(
            variant: 'success',
            heading: 'Changes saved.',
            text: 'You can always update this in your settings.',
        );
        $this->closeModal();
    }

    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        $this->editId = $assignment->id;
        $this->title = $assignment->title;
        $this->description = $assignment->description;
        $this->deadline = $assignment->deadline;
        $this->material_id = $assignment->material_id;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $assignment = Assignment::findOrFail($this->editId);
        $assignment->update([
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'material_id' => $this->material_id,
        ]);

        Flux::toast(
            variant: 'success',
            heading: 'Changes saved.',
            text: 'You can always update this in your settings.',
        );
        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
        $this->dispatch('open-modal', name: 'confirm-delete');
    }

    public function delete()
    {
        Assignment::findOrFail($this->confirmingDelete)->delete();
        $this->confirmingDelete = false;
        Flux::toast(
            variant: 'success',
            heading: 'Changes saved.',
            text: 'You can always update this in your settings.',
        );
    }
}
