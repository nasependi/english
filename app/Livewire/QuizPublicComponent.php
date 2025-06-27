<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;

class QuizPublicComponent extends Component
{
    public $questions;
    public $currentQuestionIndex = 0;
    public $totalQuestions;
    public $progress = 0;

    public function mount()
    {
        // Ambil semua soal berdasarkan quiz_id tertentu (misal: 1)
        $this->questions = Question::with('options')->where('quiz_id', 1)->get();
        $this->totalQuestions = $this->questions->count();
        $this->calculateProgress();
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->calculateProgress();
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->calculateProgress();
        }
    }

    public function calculateProgress()
    {
        if ($this->totalQuestions > 0) {
            $this->progress = (($this->currentQuestionIndex + 1) / $this->totalQuestions) * 100;
        } else {
            $this->progress = 0;
        }
    }

    public function render()
    {
        $currentQuestion = $this->questions[$this->currentQuestionIndex] ?? null;
        return view('public.quiz', [
            'question' => $currentQuestion,
            'progress' => $this->progress,
            'currentIndex' => $this->currentQuestionIndex + 1,
            'total' => $this->totalQuestions,
        ]);
    }
}
