<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Submission;
use App\Models\Assignment;

class SubmissionComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $assignment_id, $pdf_file, $answer_text, $feedback, $submitted_at, $editId;
    public $showModal = false;
    public $confirmingDelete = false;
    public $selectedAssignmentId;
    public $assignments; // Array of assignments
    public $assignmentTitle = '';


    protected $rules = [
        'selectedAssignmentId' => 'required|exists:assignment,id',
        'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
        'answer_text' => 'nullable|string',
        'feedback' => 'nullable|string',
        'submitted_at' => 'nullable|date',
    ];


    public function render()
    {
        $submissions = Submission::with('assignment')
            ->where('student_id', Auth::id())
            ->latest()
            ->paginate(5);

        $this->assignments = Assignment::all();

        // Set title agar autocomplete tetap sinkron saat edit
        if ($this->selectedAssignmentId && !$this->assignmentTitle) {
            $assignment = $this->assignments->find($this->selectedAssignmentId);
            $this->assignmentTitle = $assignment?->title;
        }

        return view('livewire.submission-component', [
            'submissions' => $submissions,
            'assignments' => $this->assignments,
        ]);
    }


    public function openModal()
    {
        $this->resetFields();
        $this->submitted_at = now()->format('Y-m-d\TH:i');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->showModal = false;
    }

    public function resetFields()
    {
        $this->assignment_id = null;
        $this->pdf_file = null;
        $this->answer_text = '';
        $this->feedback = '';
        $this->submitted_at = now();
        $this->editId = null;
    }

    public function store()
    {
        $validated = $this->validate();

        Submission::create([
            'assignment_id' => $this->selectedAssignmentId,
            'student_id' => Auth::id(),
            'pdf_file' => $this->pdf_file?->store('submissions', 'public'),
            'answer_text' => $this->answer_text,
            'submitted_at' => now(),
        ]);

        $this->closeModal();
        session()->flash('message', 'Submission created successfully.');
    }


    public function edit($id)
    {
        $submission = Submission::findOrFail($id);
        $this->editId = $submission->id;
        $this->assignment_id = $submission->assignment_id;
        $this->answer_text = $submission->answer_text;
        $this->feedback = $submission->feedback;
        $this->submitted_at = $submission->submitted_at;
        $this->selectedAssignmentId = $submission->assignment_id;
        $this->assignmentTitle = $submission->assignment->title;

        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $submission = Submission::findOrFail($this->editId);
        $filePath = $this->pdf_file?->store('submissions', 'public') ?? $submission->pdf_file;

        $submission->update([
            'assignment_id' => $this->selectedAssignmentId, // dulu: $this->assignment_id
            'pdf_file' => $filePath,
            'answer_text' => $this->answer_text,
            'feedback' => $this->feedback,
            'submitted_at' => $this->submitted_at,
        ]);


        $this->closeModal();
        session()->flash('message', 'Submission updated successfully.');
    }

    public function confirmDelete($id)
    {
        $this->editId = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        Submission::findOrFail($this->editId)->delete();
        $this->confirmingDelete = false;
        session()->flash('message', 'Submission deleted successfully.');
    }
}
