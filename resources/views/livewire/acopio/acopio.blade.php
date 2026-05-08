<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="mb-3 relative max-w-sm">
        <input type="date" class="input bg-base-100" wire:model.live.lazy="fechaReporte"
            placeholder="Seleccione fecha" />
    </div>

    <div class="flex gap-2 mb-4 overflow-x-auto">

        @foreach ($localidades as $localidad)
            <button wire:click="$set('localidadId', {{ $localidad->id }})"
                class="px-4 py-2 rounded 
                {{ $localidadId == $localidad->id ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                {{ $localidad->nombre }}
            </button>
        @endforeach

    </div>

    <table class="table">

        <thead>
            <tr>
                <th>Nombres</th>

                @foreach ($fechas as $fecha)
                    <th>
                        {{ $fecha->translatedFormat('D d') }}
                    </th>
                @endforeach

                <th>Total entregados</th>
                <th>Precio litro</th>
            </tr>
        </thead>

    </table>


</div>
