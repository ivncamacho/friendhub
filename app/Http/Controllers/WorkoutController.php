<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
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
            'user_id' => Auth::id(),
        ]);

        $workout->exercises()->attach($request->exercises);

        return redirect()->route('feed')->with('status', 'Entrenamiento creado con éxito.');
    }
}
