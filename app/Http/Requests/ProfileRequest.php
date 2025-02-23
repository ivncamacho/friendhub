<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:users,name,'.auth()->id(),
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'name.unique' => 'El nombre ya está en uso',
            'email.required' => 'El email es requerido',
            'email.string' => 'El email debe ser una cadena de texto',
            'email.email' => 'El email debe ser una dirección de correo válida',
            'email.max' => 'El email no puede tener más de 255 caracteres',
            'email.unique' => 'El email ya está en uso',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'profile_photo.image' => 'El archivo debe ser una imagen',
            'profile_photo.mimes' => 'El archivo debe ser una imagen de tipo: jpeg, png, jpg, gif, svg',
            'profile_photo.max' => 'El archivo no puede pesar más de 2MB',
        ];
    }
}
