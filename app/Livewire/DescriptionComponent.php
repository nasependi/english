<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Material;

class DescriptionComponent extends Component
{
    public $chapter;

    public function mount($id)
    {
        // GANTI MaterialComponent -> Material
        $this->chapter = Material::findOrFail($id);
    }

    public function render()
    {
        return view('public.description', [
            'chapter' => $this->chapter
        ])
            ->layout('layout.eduquest');
    }
}
