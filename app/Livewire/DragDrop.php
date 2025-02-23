<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DragDrop extends Component
{
    use WithFileUploads;

    public $profile_photo;

    public function updatedProfilePhoto()
    {
        $this->validate([
            'profile_photo' => 'image|max:2048', // Máximo 2MB
        ]);
    }

    public function save()
    {
        $this->validate([
            'profile_photo' => 'image|max:2048', // Máximo 2MB
        ]);

        // Generar un nombre único para el archivo
        $fileName = uniqid().'.'.$this->profile_photo->getClientOriginalExtension();

        // Guardar la imagen en storage/app/public/profile_images
        $filePath = $this->profile_photo->storeAs('profile_images', $fileName, 'public');

        // Guardar la ruta en la base de datos (usando la ruta accesible desde `public/storage/`)
        $user = auth()->user();
        $user->profile_photo = 'storage/'.$filePath;
        $user->save();

        session()->flash('message', 'Imagen subida y guardada correctamente.');

        $this->reset('profile_photo');
    }

    public function render()
    {
        return view('livewire.drag-drop');
    }
}
