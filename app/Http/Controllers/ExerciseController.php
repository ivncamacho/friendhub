<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        // Obtén los ejercicios paginados de 12 en 12
        $exercises = Exercise::paginate(12);

        // Pasa los ejercicios a la vista
        return view('famous-workouts', compact('exercises'));
    }
    public function show($id)
    {
        // Obtén el ejercicio por su ID
        $exercise = Exercise::findOrFail($id);

        // Pasa los datos a la vista
        return view('exercise.show', compact('exercise'));
    }

}
