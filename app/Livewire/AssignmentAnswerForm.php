<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class AssignmentAnswerForm extends Component
{
    public $assignment;
    public $answer;

    public function mount($assignment)
    {
        $this->assignment = $assignment;
    }

    public function submitAnswer()
    {
        $this->validate([
            'answer' => 'required|string|max:1000',
        ]);

        Submission::create([
            'assignment_id' => $this->assignment->id,
            'user_id' => Auth::id(),
            'answer' => $this->answer,
        ]);

        session()->flash('success', 'Jawaban berhasil disimpan!');
        $this->answer = '';
    }

    public function render()
    {
        return view('public.assignment-list-by-chapter')->layout('layout.eduquest');;
    }
}
