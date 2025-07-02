<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;

class QuizListComponent extends Component
{
    public function render()
    {
        $quizzes = Quiz::with('teacher')
            ->withCount('questions')
            ->whereHas('questions') // Hanya tampilkan quiz yang memiliki soal
            ->get();
            
        return view('public.quiz-list', compact('quizzes'))
            ->layout('layout.eduquest');
    }
}
