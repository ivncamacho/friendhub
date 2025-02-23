<div>
    <!-- Campo de entrada para la imagen -->
    <label for="profile_photo" class="block text-sm font-medium mb-2">{{ __('Profile Picture') }}</label>

    <input type="file" wire:model="profile_photo" id="profile_photo"
           accept="image/*"
           class="w-full p-3 rounded-lg bg-[#022133] border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">

    @error('profile_photo')
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror

    <!-- Vista previa de la imagen (si ya se cargó) -->
    @if ($profile_photo)
        <div class="mt-4">
            <img src="{{ $profile_photo->temporaryUrl() }}" alt="Preview" class="w-32 h-32 rounded-full">
        </div>
    @endif

    <!-- Indicador de carga -->
    <div wire:loading wire:target="profile_photo" class="mt-2 text-blue-500">
        Subiendo imagen...
    </div>

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="mt-4 text-green-500">
            {{ session('message') }}
        </div>
    @endif

    <!-- Botón para guardar -->
    <button type="submit" wire:click="save"
            wire:loading.attr="disabled" wire:target="save"
            class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 disabled:bg-gray-500">
        {{ __('Save Changes') }}
    </button>
</div>
