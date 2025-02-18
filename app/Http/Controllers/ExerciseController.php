<?php

namespace App\Http\Controllers;

use App\Events\ExercisePublished;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExerciseController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        // Obtén los ejercicios paginados de 12 en 12
        $exercises = Exercise::paginate(12);

        // Pasa los ejercicios a la vista
        return view('famous-workouts', compact('exercises'));
    }
    public function show($id)
    {
        $exercise = Exercise::findOrFail($id);

        return view('exercise.show', compact('exercise'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'youtube_video_id' => 'nullable|string|max:255',
        ]);


        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('assets/img/exercises', 'public');
        } else {
            $mediaPath = null;
        }


        $exercise = Exercise::create([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $mediaPath ? basename($mediaPath) : null,
            'youtube_video_id' => $request->youtube_video_id,
            'user_id' => auth()->id(),
        ]);

        event(new ExercisePublished($exercise));
        return redirect()->route('famous-workouts')->with('success', 'Ejercicio creado correctamente.');
    }

    public function create()
    {

        return view('exercise.create');
    }
    public function search(Request $request)
    {

        $query = $request->get('q');

        $exercises = Exercise::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();


        return response()->json($exercises);
    }
    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);

        return view('exercise.edit', compact('exercise'));
    }

    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);


        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'youtube_video_id' => 'nullable|string|max:255',
        ]);


        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->youtube_video_id = $request->youtube_video_id;

        // Manejo de la imagen
        if ($request->hasFile('media')) {
            // Obtener solo el nombre del archivo
            $fileName = time() . '.' . $request->file('media')->getClientOriginalExtension();

            // Mover la imagen a la carpeta pública "exercises_images"
            $request->file('media')->move(public_path('assets/img/exercises'), $fileName);

            // Guardar solo el nombre en la base de datos
            $exercise->media = $fileName;
        }

        $exercise->save();

        return redirect()->route('exercise.show', $exercise->id)->with('success', 'Ejercicio actualizado correctamente');
    }


    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);

        $exercise->delete();

        return redirect()->route('famous-workouts')->with('success', 'Ejercicio eliminado correctamente.');    }

}
