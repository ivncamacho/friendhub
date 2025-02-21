<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'youtube_video_id' => 'nullable|string|max:255',
        ];
    }
    public function messages()
    {
        return [
          'title.required' => 'El título es obligatorio',
            'title.max' => 'El título no puede tener más de 255 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'media.image' => 'El archivo debe ser una imagen',
            'media.mimes' => 'El archivo debe ser una imagen de tipo: jpeg, png, jpg, gif',
            'media.max' => 'El archivo no puede pesar más de 2MB',
            'youtube_video_id.max' => 'El ID del video de YouTube no puede tener más de 255 caracteres',
        ];
    }
}
