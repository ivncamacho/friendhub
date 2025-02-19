<?php

namespace App\Http\Controllers\Api;

use App\Events\ExercisePublished;
use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ExerciseController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *     path="/api/exercises",
     *     summary="Obtener todos los ejercicios",
     *     description="Devuelve una lista de todos los ejercicios disponibles",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de ejercicios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="media", type="string", nullable=true),
     *                 @OA\Property(property="youtube_video_id", type="string", nullable=true)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Exercise::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/exercises/{id}",
     *     summary="Obtener un ejercicio por ID",
     *     description="Devuelve un ejercicio específico por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del ejercicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del ejercicio",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="media", type="string", nullable=true),
     *             @OA\Property(property="youtube_video_id", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=404, description="Ejercicio no encontrado")
     * )
     */
    public function show($id)
    {
        $exercise = Exercise::findOrFail($id);
        return response()->json($exercise, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/exercises",
     *     summary="Crear un nuevo ejercicio",
     *     description="Crea un nuevo ejercicio en la base de datos",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="media", type="string", nullable=true),
     *             @OA\Property(property="youtube_video_id", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ejercicio creado correctamente",
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
        event(new ExercisePublished($exercise));
        return response()->json(['message' => 'Ejercicio creado correctamente', 'exercise' => $exercise], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/exercises/{id}",
     *     summary="Actualizar un ejercicio",
     *     description="Actualiza un ejercicio existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del ejercicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="media", type="string", nullable=true),
     *             @OA\Property(property="youtube_video_id", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ejercicio actualizado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     *     @OA\Response(response=404, description="Ejercicio no encontrado")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/exercises/{id}",
     *     summary="Eliminar un ejercicio",
     *     description="Elimina un ejercicio específico por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del ejercicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ejercicio eliminado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Ejercicio no encontrado")
     * )
     */
    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);
        $this->authorize('authorExercise', $exercise);

        $exercise->delete();

        return response()->json(['message' => 'Ejercicio eliminado correctamente'], 200);
    }
}
