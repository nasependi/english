<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('quiz_result') || $showReview)
        @php
            $result = $showReview ? $reviewQuizResult : session('quiz_result');
        @endphp
        
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="text-center mb-6">
                <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center rounded-full
                    @if($result['percentage'] >= 80) bg-green-100 text-green-600
                    @elseif($result['percentage'] >= 60) bg-yellow-100 text-yellow-600  
                    @else bg-red-100 text-red-600
                    @endif">
                    <i class="material-icons text-3xl">
                        @if($result['percentage'] >= 80) 
                            sentiment_very_satisfied
                        @elseif($result['percentage'] >= 60)
                            sentiment_satisfied
                        @else
                            sentiment_dissatisfied
                        @endif
                    </i>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    @if($showReview) Review Hasil Quiz @else Quiz Selesai! @endif
                </h1>
                <p class="text-gray-600">{{ $result['quiz_title'] ?? 'Quiz' }}</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $result['score'] }}/{{ $result['total'] }}</div>
                    <div class="text-sm text-gray-600">Jawaban Benar</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold 
                        @if($result['percentage'] >= 80) text-green-600
                        @elseif($result['percentage'] >= 60) text-yellow-600  
                        @else text-red-600
                        @endif">
                        {{ $result['percentage'] }}%
                    </div>
                    <div class="text-sm text-gray-600">Persentase</div>
                </div>
            </div>

            <div class="mb-6">
                <div class="text-lg font-semibold mb-2
                    @if($result['percentage'] >= 80) text-green-600
                    @elseif($result['percentage'] >= 60) text-yellow-600  
                    @else text-red-600
                    @endif">
                    @if($result['percentage'] >= 80)
                        Excellent! 🎉
                    @elseif($result['percentage'] >= 60)
                        Good Job! 👍
                    @else
                        Keep Trying! 💪
                    @endif
                </div>
                <p class="text-gray-600">
                    @if($result['percentage'] >= 80)
                        Kamu sangat memahami materi dengan baik!
                    @elseif($result['percentage'] >= 60)
                        Cukup baik, tapi masih bisa ditingkatkan.
                    @else
                        Jangan menyerah, terus belajar dan berlatih!
                    @endif
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($showReview)
                <button wire:click="closeReview" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="material-icons">arrow_back</i>
                    Kembali
                </button>
                @else
                <button wire:click="showReviewFromSession" 
                   class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="material-icons">visibility</i>
                    Review Jawaban
                </button>
                @endif
                
                <a href="{{ route('quiz.public') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="material-icons">refresh</i>
                    Coba Quiz Lain
                </a>
                <a href="{{ route('chapter') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="material-icons">book</i>
                    Pelajari Materi
                </a>
            </div>
        </div>

        {{-- Review Detail --}}
        @if($showReview && $reviewQuestions)
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Jawaban</h2>
            
            @foreach($reviewQuestions as $index => $question)
            @php
                $userAnswer = $result['answers'][$question->id] ?? null;
                $isCorrect = false;
                
                if ($question->type === 'pg') {
                    $isCorrect = $userAnswer === $question->answer_key;
                    $options = json_decode($question->options, true) ?? [];
                }
            @endphp
            
            <div class="mb-6 p-4 border rounded-lg @if($isCorrect) border-green-200 bg-green-50 @else border-red-200 bg-red-50 @endif">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">Soal {{ $index + 1 }}</h3>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($isCorrect) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                        @if($isCorrect) Benar @else Salah @endif
                    </span>
                </div>
                
                <p class="text-gray-800 mb-4">{!! $question->question !!}</p>
                
                @if($question->type === 'pg')
                    <div class="space-y-2">
                        @foreach($options as $key => $option)
                        <div class="flex items-center p-2 rounded
                            @if($key === $question->answer_key) bg-green-100 border border-green-300
                            @elseif($key === $userAnswer && $userAnswer !== $question->answer_key) bg-red-100 border border-red-300
                            @else bg-gray-50 border border-gray-200
                            @endif">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-sm font-medium mr-3
                                @if($key === $question->answer_key) bg-green-500 text-white
                                @elseif($key === $userAnswer && $userAnswer !== $question->answer_key) bg-red-500 text-white
                                @else bg-gray-300 text-gray-600
                                @endif">
                                {{ $key }}
                            </span>
                            <span class="text-gray-800">{{ $option }}</span>
                            @if($key === $question->answer_key)
                                <i class="material-icons text-green-500 ml-auto">check_circle</i>
                            @elseif($key === $userAnswer && $userAnswer !== $question->answer_key)
                                <i class="material-icons text-red-500 ml-auto">cancel</i>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @elseif($question->type === 'essay')
                    <div class="space-y-3">
                        <div>
                            <p class="font-medium text-gray-700 mb-2">Jawaban Anda:</p>
                            <div class="p-3 bg-gray-100 rounded border">
                                {{ $userAnswer ?: 'Tidak dijawab' }}
                            </div>
                        </div>
                        @if($question->answer_key)
                        <div>
                            <p class="font-medium text-gray-700 mb-2">Contoh Jawaban:</p>
                            <div class="p-3 bg-blue-50 rounded border border-blue-200">
                                {{ $question->answer_key }}
                            </div>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
        
        @elseif($recentResults->count() > 0)
        {{-- Statistik User --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                    <i class="material-icons">quiz</i>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalQuizzes }}</div>
                <div class="text-sm text-gray-600">Total Quiz</div>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    <i class="material-icons">trending_up</i>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($averageScore, 1) }}%</div>
                <div class="text-sm text-gray-600">Rata-rata Skor</div>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                    <i class="material-icons">star</i>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($bestScore, 1) }}%</div>
                <div class="text-sm text-gray-600">Skor Terbaik</div>
            </div>
        </div>
        
        {{-- Riwayat Quiz --}}
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Quiz</h1>
            
            <div class="space-y-4">
                @foreach($recentResults as $result)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $result->quiz->title }}</h3>
                        <p class="text-sm text-gray-600">
                            Diselesaikan: {{ $result->completed_at->format('d M Y, H:i') }}
                        </p>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-sm font-medium text-blue-600">
                                {{ $result->score }}/{{ $result->total_questions }} soal benar
                            </span>
                            <span class="text-sm font-medium 
                                @if($result->percentage >= 80) text-green-600
                                @elseif($result->percentage >= 60) text-yellow-600  
                                @else text-red-600
                                @endif">
                                {{ $result->percentage }}%
                            </span>
                        </div>
                    </div>
                    <button wire:click="showReviewForResult({{ $result->id }})" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="material-icons text-sm">visibility</i>
                        Review
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        
        @else
        {{-- Belum ada quiz --}}
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center rounded-full bg-gray-100 text-gray-400">
                <i class="material-icons text-3xl">quiz</i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Hasil Quiz</h1>
            <p class="text-gray-600 mb-6">Kamu belum mengerjakan quiz apapun.</p>
            
            <a href="{{ route('quiz.public') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 inline-flex items-center gap-2">
                <i class="material-icons">play_arrow</i>
                Mulai Quiz
            </a>
        </div>
        @endif
        
    </div>
</div>
