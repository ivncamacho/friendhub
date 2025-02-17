<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;

class ExerciseSearch extends Component
{
    public $search = '';  // Propiedad para manejar el término de búsqueda

    public function render()
    {
        // Filtrar ejercicios basados en la búsqueda
        $exercises = Exercise::where('title', 'like', '%' . $this->search . '%')
            ->paginate(12);

        return view('livewire.exercise-search', compact('exercises'));
    }
}
