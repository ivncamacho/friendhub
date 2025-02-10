<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Mostrar formulario de edición del perfil
    public function edit()
    {
        return view('profile.edit');
    }

    // Actualizar datos del perfil
    public function update(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . auth()->id(),
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Actualizar nombre y email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Manejo de la foto de perfil
        if ($request->has('profile_photo')) {
            // Eliminar la foto anterior si existe
            if ($user->profile_photo) {
                Storage::delete('profile_images/' . $user->profile_photo);
            }

            // Subir la nueva foto
            $imagePath = $request->file('profile_photo')->store('profile_images', 'public');
            $user->profile_photo = basename($imagePath);
        }

        // Actualizar la contraseña si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Guardar los cambios
        $user->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Cambios efectuados correctamente');
    }

    // Metodo para eliminar la foto de perfil
    public function destroy()
    {
        $user = auth()->user();

        // Verificar si tiene foto de perfil
        if ($user->profile_photo) {
            // Eliminar la imagen del almacenamiento
            Storage::delete('profile_images/' . $user->profile_photo);

            // Restablecer la foto en la base de datos
            $user->profile_photo = null;
            $user->save();

            return redirect()->route('dashboard')->with('success', 'Foto de perfil eliminada con éxito.');
        }

        return redirect()->route('dashboard')->with('error', 'No se encontró ninguna foto de perfil para eliminar.');
    }
}
