<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class QuizPublicComponent extends Component
{
    public $questions;
    public $currentQuestionIndex = 0;
    public $totalQuestions;
    public $progress = 0;
    public $quizId;
    public $quiz;

    public $selectedOption = null;
    public $answers = [];

    public function mount($quizId = null)
    {
        // Jika quiz ID tidak diberikan, ambil quiz pertama yang tersedia
        if ($quizId) {
            $this->quiz = Quiz::with('questions')->find($quizId);
            if (!$this->quiz) {
                session()->flash('error', 'Quiz tidak ditemukan.');
                return redirect()->route('quiz.public');
            }
            $this->quizId = $quizId;
            $this->questions = $this->quiz->questions;
        } else {
            // Ambil quiz pertama yang memiliki soal
            $this->quiz = Quiz::whereHas('questions')->with('questions')->first();
            if ($this->quiz) {
                $this->quizId = $this->quiz->id;
                $this->questions = $this->quiz->questions;
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

        // Hitung skor
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

        $percentage = $totalQuestions > 0 ? round(($score / $totalQuestions) * 100, 2) : 0;

        // Simpan hasil ke database
        $quizResult = QuizResult::create([
            'quiz_id' => $this->quizId,
            'user_id' => Auth::id(), // null jika guest
            'session_id' => Auth::guest() ? session()->getId() : null,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'percentage' => $percentage,
            'answers' => $this->answers,
            'completed_at' => now(),
        ]);

        // Simpan hasil ke session untuk ditampilkan
        session()->flash('quiz_result', [
            'id' => $quizResult->id,
            'quiz_title' => $this->quiz->title,
            'score' => $score,
            'total' => $totalQuestions,
            'percentage' => $percentage,
            'answers' => $this->answers,
            'quiz_id' => $this->quizId,
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
