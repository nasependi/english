<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Quiz Bahasa Inggris</h1>
            <p class="text-lg text-gray-600">Pilih quiz yang ingin kamu kerjakan</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($quizzes as $quiz)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $quiz->title }}</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ $quiz->questions_count }} soal
                    </span>
                </div>
                
                <div class="mb-4">
                    <p class="text-gray-600 mb-2">
                        <i class="material-icons text-sm align-middle mr-1">schedule</i>
                        Durasi: {{ $quiz->duration }} menit
                    </p>
                    <p class="text-gray-600">
                        <i class="material-icons text-sm align-middle mr-1">person</i>
                        Oleh: {{ $quiz->teacher->name ?? 'Admin' }}
                    </p>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('quiz.take', $quiz->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="material-icons text-sm">play_arrow</i>
                        Mulai Quiz
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="material-icons text-6xl">quiz</i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Quiz</h3>
                <p class="text-gray-600">Quiz akan segera tersedia. Silakan kembali lagi nanti.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
