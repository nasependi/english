<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Material;

class ChapterComponent extends Component
{
    public function render()
    {
        $chapters = Material::all();
        return view('public.chapter', compact('chapters'))
            ->layout('layout.eduquest');
    }
}
