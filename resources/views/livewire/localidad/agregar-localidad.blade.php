<div>
    {{-- The whole world belongs to you. --}}

    <form wire:submit.prevent="agregar">
        
        <fieldset class="fieldset bg-base-300 border-base-300 rounded-box border p-4 mt-3">
            <legend class="fieldset-legend">AGREGAR COMARCA</legend>

            <x-localidad.alerts type="success" :message="session('status')" />

            @error('nombre')
                <x-localidad.alerts type="error" :message="$message" />
            @enderror

            <label class="label">Nombre</label>
            <input type="text" wire:model="nombre" class="input input-bordered bg-base-100 text-base-content" />

            <x-localidad.boton-guardar target="agregar" texto="Guardar" />

        </fieldset>
    </form>

</div>
