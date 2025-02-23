<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Component;
use Livewire\WithPagination;

class ExerciseSearch extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {

        $exercises = Exercise::search($this->search)->paginate(12);

        return view('livewire.exercise-search', compact('exercises'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
