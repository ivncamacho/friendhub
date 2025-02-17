<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return response()->json(Exercise::all(), 200);
    }

    public function show($id)
    {
        $exercise = Exercise::findOrFail($id);
        return response()->json($exercise, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|string|max:255',
            'youtube_video_id' => 'nullable|string|max:255',
        ]);

        $exercise = Exercise::create([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $request->media,
            'youtube_video_id' => $request->youtube_video_id,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Ejercicio creado correctamente', 'exercise' => $exercise], 201);
    }



    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|string|max:255',
            'youtube_video_id' => 'nullable|string|max:255',
        ]);

        $exercise->update($request->only(['title', 'description', 'youtube_video_id']));

        return response()->json(['message' => 'Ejercicio actualizado correctamente', 'exercise' => $exercise], 200);
    }

    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);

        $exercise->delete();

        return response()->json(['message' => 'Ejercicio eliminado correctamente'], 200);
    }
}
