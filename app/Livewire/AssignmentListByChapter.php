<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Material;

class AssignmentListByChapter extends Component
{
    public $chapter;

    public function mount($id)
    {
        $this->chapter = Material::with('assignments')->findOrFail($id);
        $chapter = Material::with('assignments')->findOrFail($id);
        $assignments = $chapter->assignments;
    }


    public function render()
    {
        return view('public.assignment-list-by-chapter', [
            'assignments' => $this->chapter->assignments,
            'chapter' => $this->chapter
        ])->layout('layout.eduquest');
    }
}
