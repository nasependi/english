@extends('layout.eduquest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('quiz_result'))
        @php
            $result = session('quiz_result');
        @endphp
        
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
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
                
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Quiz Selesai!</h1>
                <p class="text-gray-600">Berikut adalah hasil quiz kamu</p>
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
                <a href="{{ route('quiz.public') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="material-icons">refresh</i>
                    Coba Quiz Lain
                </a>
                <a href="{{ route('chapter') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="material-icons">book</i>
                    Pelajari Materi
                </a>
            </div>
        </div>
        
        @else
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
@endsection
