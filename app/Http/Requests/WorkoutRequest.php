<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkoutRequest extends FormRequest
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
            'description' => 'nullable|string',
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|integer|min:1',
        ];
    }
    public function messages()
    {
        return [
          'title.required' => 'A title is required',
            'title.max' => 'The title must not exceed 255 characters',
            'exercises.required' => 'At least one exercise is required',
            'exercises.*.exercise_id.required' => 'An exercise is required',
            'exercises.*.sets.required' => 'The number of sets is required',
            'exercises.*.reps.required' => 'The number of reps is required',
        ];
    }
}
