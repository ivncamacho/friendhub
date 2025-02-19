<?php

namespace App\Http\Controllers\Api;

use App\Events\ExercisePublished;
use App\Events\WorkoutPublished;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $workouts = Workout::select('id', 'title', 'user_id', 'description', 'created_at')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($workouts, 200);
    }

    public function show($id)
    {
        $workout = Workout::with('exercises')->findOrFail($id);
        return response()->json($workout, 200);
    }

    public function store(Request $request)
    {$data = $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'exercises' => 'required|array',
        'exercises.*.exercise_id' => 'required|exists:exercises,id',
        'exercises.*.sets' => 'required|integer',
        'exercises.*.reps' => 'required|integer',
    ]);

        $workout = Workout::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => auth()->id(),
        ]);

        foreach ($data['exercises'] as $exercise) {
            $workout->exercises()->attach($exercise['exercise_id'], [
                'sets' => $exercise['sets'],
                'reps' => $exercise['reps'],
            ]);
        }
        event(new WorkoutPublished($workout));
        return response()->json(['message' => 'Entrenamiento creado con éxito'], 201);
    }



    public function update(Request $request, $id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|integer|min:1',
        ]);

        $workout->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $exercises = collect($request->exercises)->mapWithKeys(function ($exercise) {
            return [$exercise['exercise_id'] => ['sets' => $exercise['sets'], 'reps' => $exercise['reps']]];
        });

        $workout->exercises()->sync($exercises);

        return response()->json(['message' => 'Entrenamiento actualizado correctamente', 'workout' => $workout], 200);
    }

    public function destroy($id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);

        $workout->delete();

        return response()->json(['message' => 'Entrenamiento eliminado correctamente'], 200);
    }
}
