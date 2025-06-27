<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

class QuizComponent extends Component
{
    use WithPagination;

    public $title, $duration, $editId;
    public $showModal = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'duration' => 'required|integer|min:1',
    ];

    public function render()
    {
        $quizzes = Quiz::withCount('questions')->where('teacher_id', Auth::id())->latest()->paginate(5);
        return view('livewire.quiz-component', compact('quizzes'));
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
        $this->duration = '';
        $this->editId = null;
    }

    public function store()
    {
        $this->validate();

        Quiz::create([
            'teacher_id' => Auth::id(),
            'title' => $this->title,
            'duration' => $this->duration,
        ]);

        Flux::toast(variant: 'success', heading: 'Saved', text: 'Quiz created successfully.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $this->editId = $quiz->id;
        $this->title = $quiz->title;
        $this->duration = $quiz->duration;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $quiz = Quiz::findOrFail($this->editId);
        $quiz->update([
            'title' => $this->title,
            'duration' => $this->duration,
        ]);

        Flux::toast(variant: 'success', heading: 'Updated', text: 'Quiz updated successfully.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Quiz::findOrFail($id)->delete();
        Flux::toast(variant: 'success', heading: 'Deleted', text: 'Quiz deleted successfully.');
    }
}
