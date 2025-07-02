<?php

namespace App\Livewire;

use Flux\Flux;
use App\Models\Quiz;
use Livewire\Component;
use App\Models\Question;

class QuizDetailComponent extends Component
{
    public $quiz;
    public $questionInputs = [];

    public function mount($quizId)
    {
        $this->quiz = Quiz::with('questions')->findOrFail($quizId);

        foreach ($this->quiz->questions as $question) {
            $options = [];
            if ($question->type === 'pg' && $question->options) {
                $decodedOptions = json_decode($question->options, true);
                $options = is_array($decodedOptions) ? $decodedOptions : ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
            }

            $this->questionInputs[] = [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->type,
                'options' => $options,
                'answer_key' => $question->answer_key,
            ];
        }
    }


    public function render()
    {
        return view('livewire.quiz-detail-component');
    }

    public function addQuestion()
    {
        $this->questionInputs[] = [
            'question' => '',
            'type' => 'pg',
            'options' => ['A' => '', 'B' => '', 'C' => '', 'D' => ''],
            'answer_key' => '',
        ];
    }

    public function removeQuestion($index)
    {
        if (isset($this->questionInputs[$index]['id'])) {
            Question::where('id', $this->questionInputs[$index]['id'])->delete();
        }

        unset($this->questionInputs[$index]);
        $this->questionInputs = array_values($this->questionInputs); // reindex
    }

    public function saveQuestions()
    {
        $this->validate([
            'questionInputs.*.question' => 'required|string|max:1000',
            'questionInputs.*.type' => 'required|in:pg,essay',
            'questionInputs.*.answer_key' => 'required|string|max:500',
        ]);

        foreach ($this->questionInputs as $input) {
            if (empty($input['question'])) continue;

            // Validasi untuk pilihan ganda
            if ($input['type'] === 'pg') {
                $options = $input['options'] ?? [];
                
                // Pastikan semua opsi terisi
                foreach (['A', 'B', 'C', 'D'] as $option) {
                    if (empty($options[$option])) {
                        Flux::toast(
                            heading: 'Error',
                            text: "Semua opsi (A, B, C, D) harus diisi untuk soal: " . substr($input['question'], 0, 50) . "...",
                            variant: 'danger'
                        );
                        return;
                    }
                }

                // Validasi kunci jawaban
                if (!in_array(strtoupper($input['answer_key']), ['A', 'B', 'C', 'D'])) {
                    Flux::toast(
                        heading: 'Error',
                        text: "Kunci jawaban harus A, B, C, atau D untuk soal: " . substr($input['question'], 0, 50) . "...",
                        variant: 'danger'
                    );
                    return;
                }
            }

            // Update jika sudah ada id
            if (!empty($input['id'])) {
                $question = Question::find($input['id']);
                if ($question) {
                    $question->update([
                        'question' => $input['question'],
                        'type' => $input['type'],
                        'options' => $input['type'] === 'pg' ? json_encode($input['options']) : null,
                        'answer_key' => strtoupper($input['answer_key']),
                    ]);
                }
            } else {
                // Buat baru
                Question::create([
                    'quiz_id' => $this->quiz->id,
                    'question' => $input['question'],
                    'type' => $input['type'],
                    'options' => $input['type'] === 'pg' ? json_encode($input['options']) : null,
                    'answer_key' => strtoupper($input['answer_key']),
                ]);
            }
        }

        // Refresh quiz data
        $this->quiz = Quiz::with('questions')->findOrFail($this->quiz->id);

        Flux::toast(
            heading: 'Tersimpan',
            text: 'Semua soal berhasil disimpan.',
            variant: 'success'
        );
    }

    public function updatedQuestionInputs($value, $key)
    {
        // Reset options ketika tipe soal berubah
        if (strpos($key, '.type') !== false) {
            $index = explode('.', $key)[0];
            if ($this->questionInputs[$index]['type'] === 'pg') {
                $this->questionInputs[$index]['options'] = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
                $this->questionInputs[$index]['answer_key'] = '';
            } else {
                $this->questionInputs[$index]['options'] = [];
                $this->questionInputs[$index]['answer_key'] = '';
            }
        }
    }
}
