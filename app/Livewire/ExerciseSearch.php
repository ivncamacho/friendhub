<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Exercise;

class ExerciseSearch extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {

        $exercises = Exercise::where('title', 'like', '%' . $this->search . '%')
            ->paginate(12);

        return view('livewire.exercise-search', compact('exercises'));
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
}
