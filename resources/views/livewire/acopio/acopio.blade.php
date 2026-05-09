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

    <table class="table min-w-full border-collapse">

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

        @foreach ($this->productores as $productor)
        <tr>
            <td class="border border-gray-300 text-sm whitespace-nowrap">{{ $productor->nombre }}</td>

            @foreach ($fechas as $fecha)
            @php
            $acopio = $this->acopiosMap[$productor->id][$fecha->toDateString()] ?? null;
            @endphp

            <td class="border border-gray-300 text-sm text-center align-middle p-0">
                <input
                    type="number"
                    value="{{ $acopio->litros ?? '' }}"
                    wire:blur="guardar({{ $productor->id }}, '{{ $fecha->toDateString() }}', $event.target.value)"
                    class="w-full h-7 text-center text-sm bg-base-100 border border-gray-500 rounded-none p-0">
            </td>
            @endforeach

            <td class="border border-gray-300 text-sm text-center"></td>
            <td class="border border-gray-300 text-sm text-center"></td>
        </tr>
        @endforeach

    </table>


</div>