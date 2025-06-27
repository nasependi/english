<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;

class QuizQuestionComponent extends Component
{
    public $quiz_id, $question, $type = 'pg', $options = [], $answer_key;
    public $editId = null, $showModal = false;

    protected $rules = [
        'quiz_id' => 'required|exists:quiz,id',
        'question' => 'required|string',
        'type' => 'required|in:pg,essay',
        'options' => 'nullable|array',
        'answer_key' => 'nullable|string',
    ];


    public function render()
    {
        $questions = Question::where('quiz_id', $this->quiz_id)->get();
        return view('livewire.quiz-question-component', compact('questions'));
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate();

        if ($this->type === 'pg' && !in_array($this->answer_key, ['A', 'B', 'C', 'D', 'E'])) {
            $this->addError('answer_key', 'Kunci jawaban harus A, B, C, D, atau E.');
            return;
        }

        Question::create([
            'quiz_id' => $this->quiz_id,
            'question' => $this->question,
            'type' => $this->type,
            'options' => $this->type === 'pg' ? json_encode($this->options) : null,
            'answer_key' => $this->answer_key,
        ]);

        $this->closeModal();
        $this->resetForm();

        \Flux\Flux::toast(
            variant: 'success',
            heading: 'Saved',
            text: 'Question successfully created.'
        );
    }


    public function edit($id)
    {
        $q = Question::findOrFail($id);
        $this->editId = $q->id;
        $this->question = $q->question;
        $this->type = $q->type;
        $this->options = $q->type === 'pg' ? json_decode($q->options, true) : [];
        $this->answer_key = $q->type === 'pg' ? json_decode($q->answer_key, true) : $q->answer_key;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $q = Question::findOrFail($this->editId);
        $q->update([
            'question' => $this->question,
            'type' => $this->type,
            'options' => $this->type === 'pg' ? json_encode($this->options) : null,
            'answer_key' => $this->type === 'pg' ? json_encode($this->answer_key) : $this->answer_key,
        ]);

        $this->closeModal();
    }

    public function delete($id)
    {
        Question::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->editId = null;
        $this->question = '';
        $this->type = 'pg';
        $this->options = [];
        $this->answer_key = '';
    }
}
