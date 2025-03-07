<?php

namespace App\Http\Controllers;

use App\Events\ExercisePublished;
use App\Http\Requests\ExerciseRequest;
use App\Jobs\ExportDailyExercises;
use App\Models\Exercise;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class ExerciseController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $exercises = Exercise::paginate(12);

        return view('famous-workouts', compact('exercises'));
    }

    public function show($id)
    {
        $exercise = Exercise::findOrFail($id);

        return view('exercise.show', compact('exercise'));
    }

    public function store(ExerciseRequest $request)
    {
        $fileName = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');

            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();

            $file->move(public_path('assets/img/exercises'), $fileName);
        }

        $exercise = Exercise::create([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $fileName,
            'youtube_video_id' => $request->youtube_video_id,
            'user_id' => auth()->id(),
        ]);

        event(new ExercisePublished($exercise));

        ExportDailyExercises::dispatch();

        return redirect()->route('famous-workouts')->with('success', 'Ejercicio creado correctamente.');
    }

    public function create()
    {
        return view('exercise.create');
    }

    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);

        return view('exercise.edit', compact('exercise'));
    }

    public function update(ExerciseRequest $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);

        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->youtube_video_id = $request->youtube_video_id;

        if ($request->hasFile('media')) {

            $fileName = time().'.'.$request->file('media')->getClientOriginalExtension();

            $request->file('media')->move(public_path('assets/img/exercises'), $fileName);

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

        return redirect()->route('famous-workouts')->with('success', 'Ejercicio eliminado correctamente.');
    }
}
