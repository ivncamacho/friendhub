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
use OpenApi\Annotations as OA;

class WorkoutController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *     path="/api/workouts",
     *     summary="Obtener todos los entrenamientos",
     *     description="Devuelve una lista de todos los entrenamientos disponibles",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de entrenamientos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $workouts = Workout::select('id', 'title', 'user_id', 'description', 'created_at')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($workouts, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/workouts/{id}",
     *     summary="Obtener un entrenamiento por ID",
     *     description="Devuelve los detalles de un entrenamiento específico por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del entrenamiento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del entrenamiento",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Entrenamiento no encontrado")
     * )
     */
    public function show($id)
    {
        $workout = Workout::with('exercises')->findOrFail($id);
        return response()->json($workout, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/workouts",
     *     summary="Crear un nuevo entrenamiento",
     *     description="Crea un nuevo entrenamiento con los ejercicios asignados",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "exercises"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(
     *                 property="exercises",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="exercise_id", type="integer"),
     *                     @OA\Property(property="sets", type="integer"),
     *                     @OA\Property(property="reps", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Entrenamiento creado con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
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

    /**
     * @OA\Put(
     *     path="/api/workouts/{id}",
     *     summary="Actualizar un entrenamiento",
     *     description="Actualiza un entrenamiento y sus ejercicios",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del entrenamiento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "exercises"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(
     *                 property="exercises",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="exercise_id", type="integer"),
     *                     @OA\Property(property="sets", type="integer"),
     *                     @OA\Property(property="reps", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entrenamiento actualizado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Entrenamiento no encontrado")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/workouts/{id}",
     *     summary="Eliminar un entrenamiento",
     *     description="Elimina un entrenamiento específico por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del entrenamiento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entrenamiento eliminado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Entrenamiento no encontrado")
     * )
     */
    public function destroy($id)
    {
        $workout = Workout::findOrFail($id);
        $this->authorize('authorWorkout', $workout);

        $workout->delete();

        return response()->json(['message' => 'Entrenamiento eliminado correctamente'], 200);
    }
}
