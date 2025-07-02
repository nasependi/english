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

    public function mount($quizId = null)
    {
        // Jika quiz ID tidak diberikan, ambil quiz pertama yang tersedia
        if ($quizId) {
            $quiz = \App\Models\Quiz::with('questions')->find($quizId);
            if (!$quiz) {
                session()->flash('error', 'Quiz tidak ditemukan.');
                return redirect()->route('quiz.public');
            }
            $this->questions = $quiz->questions;
        } else {
            // Ambil quiz pertama yang memiliki soal
            $firstQuiz = \App\Models\Quiz::whereHas('questions')->with('questions')->first();
            if ($firstQuiz) {
                $this->questions = $firstQuiz->questions;
            } else {
                $this->questions = collect([]);
            }
        }
        
        $this->totalQuestions = $this->questions->count();

        if ($this->totalQuestions === 0) {
            session()->flash('message', 'Soal belum tersedia.');
            return;
        }

        $this->calculateProgress();
        
        // Load jawaban yang sudah disimpan jika ada
        if (isset($this->questions[0])) {
            $this->selectedOption = $this->answers[$this->questions[0]->id] ?? null;
        }
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
        // Simpan jawaban saat ini sebelum pindah
        if (!is_null($this->selectedOption)) {
            $this->answers[$this->questions[$this->currentQuestionIndex]->id] = $this->selectedOption;
        }
        
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            // Load jawaban yang sudah disimpan sebelumnya
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

    public function finishQuiz()
    {
        // Simpan jawaban terakhir jika ada
        if (!is_null($this->selectedOption)) {
            $this->answers[$this->questions[$this->currentQuestionIndex]->id] = $this->selectedOption;
        }

        // Hitung skor (opsional)
        $score = 0;
        $totalQuestions = 0;
        
        foreach ($this->questions as $question) {
            $totalQuestions++;
            $userAnswer = $this->answers[$question->id] ?? null;
            
            if ($question->type === 'pg' && $userAnswer === $question->answer_key) {
                $score++;
            }
            // Untuk essay, bisa ditambahkan logika penilaian manual
        }

        // Simpan hasil ke session atau database
        session()->flash('quiz_result', [
            'score' => $score,
            'total' => $totalQuestions,
            'percentage' => $totalQuestions > 0 ? round(($score / $totalQuestions) * 100, 2) : 0,
            'answers' => $this->answers
        ]);

        // Redirect ke halaman hasil
        return redirect()->route('score');
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
