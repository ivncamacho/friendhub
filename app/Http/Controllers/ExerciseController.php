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
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'youtube_video_id' => 'nullable|string|max:255',
        ]);

        // Verificar si se ha subido una imagen
        if ($request->hasFile('media')) {
            // Guardar la imagen en la carpeta public/assets/img/exercises
            $mediaPath = $request->file('media')->store('assets/img/exercises', 'public');
        } else {
            $mediaPath = null; // Si no se sube imagen, dejar el campo como null
        }

        // Crear el ejercicio en la base de datos
        Exercise::create([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $mediaPath ? basename($mediaPath) : null,
            'youtube_video_id' => $request->youtube_video_id,
            'user_id' => auth()->id(), // Asignar el ID del usuario autenticado
        ]);

        // Redirigir a la lista de ejercicios con un mensaje de éxito
        return redirect()->route('famous-workouts')->with('success', 'Ejercicio creado correctamente.');
    }

    public function create()
    {
        return view('exercise.create');
    }
    public function search(Request $request)
    {
        // Obtener la consulta de búsqueda
        $query = $request->get('q');

        // Buscar ejercicios que coincidan con la consulta
        $exercises = Exercise::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        // Devolver los resultados como JSON
        return response()->json($exercises);
    }
}
