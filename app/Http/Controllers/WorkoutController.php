<?php

namespace App\Http\Controllers;

use App\Events\WorkoutPublished;
use App\Http\Requests\WorkoutRequest;
use App\Jobs\GenerateWorkoutPDF;
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
        GenerateWorkoutPdf::dispatch($workout);

        return view('workouts.show', compact('workout'));
    }

    public function create()
    {
        $exercises = Exercise::all();

        return view('workouts.create', compact('exercises'));
    }


    public function store(WorkoutRequest $request)
    {


        $workout = Workout::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        $exercises = collect($request->exercises)->mapWithKeys(function ($exercise) {
            return [
                $exercise['exercise_id'] => [
                    'sets' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                ],
            ];
        });

        $workout->exercises()->attach($exercises);
        event(new WorkoutPublished($workout));
        return redirect()->route('feed')->with('status', 'Entrenamiento creado con éxito.');
    }
    public function myWorkouts()
    {
        $userId = Auth::id();
        $workouts = Workout::myWorkouts($userId)->get();

        return view('myworkouts', compact('workouts'));
    }
    public function edit($id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);
        $exercises = Exercise::all();

        return view('workouts.edit', compact('workout', 'exercises'));
    }

    public function update(WorkoutRequest $request, $id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);

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

    public function destroyFeed($id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);

        $workout->delete();

        return redirect()->route('feed')->with('success', 'Entrenamiento eliminado correctamente.');
    }
    public function destroyMy($id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);

        $workout->delete();

        return redirect()->route('myworkouts')->with('success', 'Entrenamiento eliminado correctamente.');
    }
    public function GeneratePDF($id)
    {
    $pdfPath="pdfs/workout_" . $id . ".pdf";
        return response()->download(public_path($pdfPath));
    }
}
