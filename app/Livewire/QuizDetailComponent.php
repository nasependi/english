<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Question;

class QuizDetailComponent extends Component
{
    public $quiz;
    public $questionInputs = [];

    public function mount($quizId)
    {
        $this->quiz = Quiz::with('questions')->findOrFail($quizId);

        foreach ($this->quiz->questions as $question) {
            $this->questionInputs[] = [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->type,
                'options' => $question->type === 'pg' ? json_decode($question->options, true) : [],
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
        foreach ($this->questionInputs as $input) {
            if (!isset($input['question']) || !isset($input['type'])) continue;

            // Update jika sudah ada id
            if (!empty($input['id'])) {
                $question = Question::find($input['id']);
                if ($question) {
                    $question->update([
                        'question' => $input['question'],
                        'type' => $input['type'],
                        'options' => $input['type'] === 'pg' ? json_encode($input['options']) : null,
                        'answer_key' => $input['answer_key'],
                    ]);
                }
            } else {
                // Buat baru
                Question::create([
                    'quiz_id' => $this->quiz->id,
                    'question' => $input['question'],
                    'type' => $input['type'],
                    'options' => $input['type'] === 'pg' ? json_encode($input['options']) : null,
                    'answer_key' => $input['answer_key'],
                ]);
            }
        }

        \Flux\Flux::toast(
            heading: 'Tersimpan',
            text: 'Semua soal berhasil disimpan.',
            variant: 'success'
        );
    }
}
