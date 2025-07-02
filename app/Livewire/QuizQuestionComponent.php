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

        // Validasi khusus untuk pilihan ganda
        if ($this->type === 'pg') {
            // Pastikan semua opsi terisi
            if (empty($this->options['A']) || empty($this->options['B']) || 
                empty($this->options['C']) || empty($this->options['D'])) {
                $this->addError('options', 'Semua opsi (A, B, C, D) harus diisi.');
                return;
            }
            
            if (!in_array($this->answer_key, ['A', 'B', 'C', 'D'])) {
                $this->addError('answer_key', 'Kunci jawaban harus A, B, C, atau D.');
                return;
            }
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
        
        if ($q->type === 'pg' && $q->options) {
            $decodedOptions = json_decode($q->options, true);
            $this->options = is_array($decodedOptions) ? $decodedOptions : [];
        } else {
            $this->options = [];
        }
        
        $this->answer_key = $q->answer_key ?? '';
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        // Validasi khusus untuk pilihan ganda
        if ($this->type === 'pg') {
            // Pastikan semua opsi terisi
            if (empty($this->options['A']) || empty($this->options['B']) || 
                empty($this->options['C']) || empty($this->options['D'])) {
                $this->addError('options', 'Semua opsi (A, B, C, D) harus diisi.');
                return;
            }
            
            if (!in_array($this->answer_key, ['A', 'B', 'C', 'D'])) {
                $this->addError('answer_key', 'Kunci jawaban harus A, B, C, atau D.');
                return;
            }
        }

        $q = Question::findOrFail($this->editId);
        $q->update([
            'question' => $this->question,
            'type' => $this->type,
            'options' => $this->type === 'pg' ? json_encode($this->options) : null,
            'answer_key' => $this->answer_key,
        ]);

        $this->closeModal();
        $this->resetForm();
        
        \Flux\Flux::toast(
            variant: 'success',
            heading: 'Updated',
            text: 'Question successfully updated.'
        );
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
        $this->options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
        $this->answer_key = '';
    }
    
    public function updatedType()
    {
        if ($this->type === 'pg') {
            $this->options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
            $this->answer_key = '';
        } else {
            $this->options = [];
            $this->answer_key = '';
        }
    }
}
