<?php

namespace App\Http\Controllers;

use App\Events\WorkoutPublished;
use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WorkoutController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $workouts = Workout::select('id', 'title', 'user_id', 'created_at')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('feed.mainPage', compact('workouts'));
    }


    public function show($id)
    {
        $workout = Workout::with('exercises')->findOrFail($id);
        return view('workouts.show', compact('workout'));

    }

    public function create()
    {
        $exercises = Exercise::all();

        return view('workouts.create', compact('exercises'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exercises' => 'required|array',
        ]);

        $workout = Workout::create([
            'title' => $request->title,
            'description' => $request->description,
            'exercises' => $request->exercises,
            'user_id' => Auth::id(),
        ]);

        $workout->exercises()->attach($request->exercises);
        event(new WorkoutPublished($workout));
        return redirect()->route('feed')->with('status', 'Entrenamiento creado con éxito.');
    }
    public function myWorkouts()
    {
        $userId = Auth::id();
        $workouts = Workout::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Ordenar del más nuevo al más antiguo
            ->get();

        return view('myworkouts', compact('workouts'));
    }
    public function edit($id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);
        $exercises = Exercise::all();

        return view('workouts.edit', compact('workout', 'exercises'));
    }

    public function update(Request $request, $id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);


        // Validación de los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|integer|min:1',
        ]);

        // Actualiza el título y la descripción del entrenamiento
        $workout->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Actualizar los ejercicios en la tabla pivote
        $exercises = collect($request->exercises)->map(function ($exercise) {
            return [
                'exercise_id' => $exercise['exercise_id'],
                'sets' => $exercise['sets'],
                'reps' => $exercise['reps'],
            ];
        });

        // Sincroniza los ejercicios con la relación pivote
        $workout->exercises()->sync($exercises);

        return redirect()->route('workouts.show', $workout->id)->with('success', 'Entrenamiento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);

        $workout->delete();

        return redirect()->route('feed')->with('success', 'Entrenamiento eliminado correctamente.');
    }
}
