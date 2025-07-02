<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\QuizResult;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class ScoreComponent extends Component
{
    public $showReview = false;
    public $reviewQuizResult = null;
    public $reviewQuestions = [];

    public function mount()
    {
        // Auto show review jika ada quiz result dari session
        if (session('quiz_result')) {
            $this->showReviewFromSession();
        }
    }

    public function showReviewFromSession()
    {
        $sessionResult = session('quiz_result');
        if ($sessionResult && isset($sessionResult['quiz_id'])) {
            $this->reviewQuizResult = $sessionResult;
            $this->reviewQuestions = Question::where('quiz_id', $sessionResult['quiz_id'])->get();
            $this->showReview = true;
        }
    }

    public function showReviewForResult($resultId)
    {
        $quizResult = QuizResult::with('quiz')->find($resultId);
        if ($quizResult) {
            $this->reviewQuizResult = [
                'id' => $quizResult->id,
                'quiz_title' => $quizResult->quiz->title,
                'score' => $quizResult->score,
                'total' => $quizResult->total_questions,
                'percentage' => $quizResult->percentage,
                'answers' => $quizResult->answers,
                'quiz_id' => $quizResult->quiz_id,
            ];
            $this->reviewQuestions = Question::where('quiz_id', $quizResult->quiz_id)->get();
            $this->showReview = true;
        }
    }

    public function closeReview()
    {
        $this->showReview = false;
        $this->reviewQuizResult = null;
        $this->reviewQuestions = [];
    }

    public function render()
    {
        $recentResults = [];
        $totalQuizzes = 0;
        $averageScore = 0;
        $bestScore = 0;
        
        if (Auth::check()) {
            // Ambil hasil quiz untuk user yang login
            $allResults = QuizResult::where('user_id', Auth::id())->get();
            $recentResults = QuizResult::with('quiz')
                ->where('user_id', Auth::id())
                ->orderBy('completed_at', 'desc')
                ->limit(5)
                ->get();
        } else {
            // Ambil hasil quiz untuk session guest
            $allResults = QuizResult::where('session_id', session()->getId())->get();
            $recentResults = QuizResult::with('quiz')
                ->where('session_id', session()->getId())
                ->orderBy('completed_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Hitung statistik
        if ($allResults->count() > 0) {
            $totalQuizzes = $allResults->count();
            $averageScore = $allResults->avg('percentage');
            $bestScore = $allResults->max('percentage');
        }

        return view('public.score', compact('recentResults', 'totalQuizzes', 'averageScore', 'bestScore'))
            ->layout('layout.eduquest');
    }
}
