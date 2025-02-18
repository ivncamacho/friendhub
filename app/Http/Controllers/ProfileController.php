<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Guardar los cambios
        $user->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Cambios efectuados correctamente');
    }
    public function destroy()
    {

        $user = auth()->user();

        $user->delete();

        Auth::logout();
        return redirect()->route('index');
    }
    public function destroyImage()
    {
        $user = auth()->user();
        if ($user->profile_photo) {

            Storage::delete( $user->profile_photo);


            $user->profile_photo = null;
            $user->save();

            return redirect()->route('dashboard')->with('success', 'Foto de perfil eliminada con éxito.');
        }

        return redirect()->route('dashboard')->with('error', 'No se encontró ninguna foto de perfil para eliminar.');
    }
}
