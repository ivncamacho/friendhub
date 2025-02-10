<?php

namespace App\Livewire;

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class DragDropUpload extends Component
{
    use WithFileUploads;

    public $imagenes = [];
    public $imagenesSubidas = []; // ← Asegurar que está declarada

    public function updatedImagenes()
    {
        $this->validate([
            'imagenes.*' => 'image|max:2048',
        ]);

        foreach ($this->imagenes as $imagen) {
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();

            // Guardar la imagen en public/profile_imagenes
            $imagen->storeAs('profile_imagenes', $nombreArchivo, 'public');

            // Guardar la URL de la imagen para mostrarla
            $this->imagenesSubidas[] = asset("public/profile_images/$nombreArchivo");
        }

        $this->imagenes = [];
    }

    public function render()
    {
        return view('livewire.drag-drop-upload');
    }
}
