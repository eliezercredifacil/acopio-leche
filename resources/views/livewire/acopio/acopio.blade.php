<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="mb-3 relative max-w-sm">
        <input type="date" class="input bg-base-100" wire:model.live.lazy="fechaReporte"
            placeholder="Seleccione fecha" />
    </div>

    <div class="flex gap-2 mb-4 overflow-x-auto">

        @foreach ($localidades as $localidad)
        <button wire:click="$set('localidadId', {{ $localidad->id }})"
            class="px-4 py-2 rounded btn btn-sm
                {{ $localidadId == $localidad->id ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
            {{ $localidad->nombre }}
        </button>
        @endforeach

    </div>

    <div class="overflow-x-auto">

        <table class="table min-w-full border-collapse">

            <thead>
                <tr>
                    <th class="bg-cyan-800 text-white border border-gray-300">Nombres</th>

                    @foreach ($fechas as $fecha)
                    <th class="bg-lime-700 text-white border text-center border-gray-300">
                        {{ $fecha->translatedFormat('D d') }}
                    </th>
                    @endforeach

                    <th class="border border-gray-300">Total entregados</th>
                    <th class="border border-gray-300">Precio litro</th>
                    <th class="border border-gray-300">Total córdobas</th>
                    <th class="border border-gray-300">% deducción compra</th>

                    <th class="border border-gray-300">Total entregados</th>
                    <th class="border border-gray-300">Precio litro</th>
                    <th class="border border-gray-300">Total córdobas</th>
                    <th class="border border-gray-300">% deducción compra</th>

                    <th class="border border-gray-300">Precio litro</th>
                    <th class="border border-gray-300">Total córdobas</th>
                    <th class="border border-gray-300">% deducción compra</th>
                </tr>
            </thead>

            @foreach ($this->productores as $productor)
            <tr>
                <td class="bg-gray-600 text-white sticky left-0 z-10 border border-gray-300 whitespace-nowrap">{{ $productor->nombre }}</td>

                @foreach ($fechas as $fecha)
                @php
                $acopio = $this->acopiosMap[$productor->id][$fecha->toDateString()] ?? null;
                @endphp

                <td class="border border-gray-300 text-center align-middle">
                    <input type="number" value="{{ $acopio->litros ?? '' }}"
                        wire:blur="guardar({{ $productor->id }}, '{{ $fecha->toDateString() }}', $event.target.value)"
                        class="w-12 text-center bg-base-100 border border-gray-500 rounded-none p-0">
                </td>
                @endforeach

                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>

                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>

                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>
                <td class="border border-gray-300 text-center"></td>
            </tr>
            @endforeach

        </table>

    </div>


</div>