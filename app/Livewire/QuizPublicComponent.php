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

    public $selectedOption = null;
    public $answers = [];

    public function mount()
    {
        $this->questions = Question::where('quiz_id', 1)->get();
        $this->totalQuestions = $this->questions->count();

        if ($this->totalQuestions === 0) {
            session()->flash('message', 'Soal belum tersedia.');
            return;
        }

        $this->calculateProgress();
    }


    public function nextQuestion()
    {
        // Validasi: pastikan user memilih jawaban
        if (is_null($this->selectedOption)) {
            session()->flash('message', 'Silakan pilih salah satu jawaban terlebih dahulu.');
            return;
        }

        // Simpan jawaban user
        $this->answers[$this->questions[$this->currentQuestionIndex]->id] = $this->selectedOption;

        // Reset pilihan
        $this->selectedOption = null;

        // Lanjut ke soal berikutnya
        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->calculateProgress();
        } else {
            // Sudah di soal terakhir → bisa diarahkan ke hasil
            session()->flash('message', 'Semua jawaban telah dikumpulkan.');
            // Contoh redirect (nanti bisa dikustom)
            // return redirect()->route('score');
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->selectedOption = $this->answers[$this->questions[$this->currentQuestionIndex]->id] ?? null;
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
        ])->layout('layout.eduquest');
    }
}
