<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}


    <form wire:submit.prevent="actualizar">
        <fieldset class="fieldset bg-base-300 border-base-300 rounded-box border p-4 mt-3">
            <legend class="fieldset-legend">EDITAR DATOS</legend>

            <x-localidad.alerts type="success" :message="session('status')" />

            <x-localidad.alerts type="info" :message="session('info')" />

            @error('nombre')
                <x-localidad.alerts type="error" :message="$message" />
            @enderror

            <label class="label">Nombre</label>
            <input type="text" wire:model="nombre" class="input input-bordered bg-base-100 text-base-content" />

            <x-localidad.boton-guardar target="actualizar" texto="Actualizar" />

            <p class="mt-2 text-sm text-gray-500">Creado el
                {{ $creado->translatedFormat('l d \d\e F \d\e Y h:i a') }}
            </p>

            <p class="mt-2 text-sm text-gray-500">
                Actualizado {{ $actualizado->diffForHumans() }} el
                {{ $actualizado->translatedFormat('l d \d\e F \d\e Y h:i a') }}
            </p>

        </fieldset>

    </form>





</div>
