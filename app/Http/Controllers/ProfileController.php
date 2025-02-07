<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Procesar la imagen si se ha subido
        if ($request->has('profile_photo')) {
            // Eliminar la imagen anterior si existe
            if ($user->profile_photo && Storage::exists('profile_images/' . $user->profile_photo)) {
                Storage::unlink('profile_images/' . $user->profile_photo);
            }

            // Guardar la imagen
            $imageName = time() . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('profile_images/'), $imageName);

            // Guardar en la base de datos
            $user->profile_photo = $imageName;
        }


        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Redirigir al dashboard con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Cambios efectuados correctamente');
    }



    // Metodo para eliminar la foto de perfil
    public function destroy(Request $request)
    {
        $user = auth()->user();

        // Verificar si el usuario tiene una foto de perfil
        if ($user->profile_photo) {
            $imagePath = public_path($user->profile_photo);

            // Verificar si la imagen existe en la carpeta y eliminarla
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Restablecer el campo de la foto de perfil en la base de datos
            $user->profile_photo = null;
            $user->save();

            return redirect()->route('dashboard')->with('success', 'Foto de perfil eliminada con éxito.');
        }

        return redirect()->route('dashboard')->with('error', 'No se encontró ninguna foto de perfil para eliminar.');
    }

}
