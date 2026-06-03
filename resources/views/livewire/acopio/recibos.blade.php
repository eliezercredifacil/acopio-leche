<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="mb-3 relative max-w-sm">
        <input type="date" class="input bg-base-100 w-1/2" wire:model.lazy="fechaReporte" />

        {{-- Spinner global --}}
        <div wire:loading.delay wire:target="fechaReporte">
            <span class="loading loading-spinner loading-md"></span>
        </div>
    </div>

    <!-- Botones para seleccionar localidad -->
    <div class="flex gap-2 mb-4 overflow-x-auto">

        @foreach ($localidades as $localidad)
        <button wire:click="$set('localidadId', {{ $localidad->id }})"
            class="px-4 py-2 rounded btn btn-sm
                {{ $localidadId == $localidad->id ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">

            @if($localidadId == $localidad->id)
            <i class="fa-solid fa-caret-right mr-1"></i>
            @endif

            {{ $localidad->nombre }}
        </button>
        @endforeach

        {{-- Spinner global --}}
        <div wire:loading.delay wire:target="localidadId">
            <span class="loading loading-spinner loading-md"></span>
        </div>

    </div>

    <!-- Botones para seleccionar tipo de semana -->

    <div class="flex gap-2 mb-4">

        <div class="flex items-center gap-2 mb-4">

            <button
                wire:click="$set('tipoSemana', 'A')"
                class="px-4 py-2 rounded btn btn-sm {{ $tipoSemana === 'A' ? 'bg-primary font-bold text-white' : 'bg-gray-200 dark:bg-gray-700' }}">

                @if($tipoSemana == 'A')
                <i class="fa-solid fa-caret-right mr-1"></i>
                @endif

                Domingo a Sábado
            </button>

            <button
                wire:click="$set('tipoSemana', 'B')"
                class="px-4 py-2 rounded btn btn-sm {{ $tipoSemana === 'B' ? 'bg-primary font-bold text-white' : 'bg-gray-200 dark:bg-gray-700' }}">

                @if($tipoSemana == 'B')
                <i class="fa-solid fa-caret-right mr-1"></i>
                @endif

                Viernes a Jueves
            </button>

            {{-- Spinner global --}}
            <div wire:loading.delay wire:target="tipoSemana">
                <span class="loading loading-spinner loading-md"></span>
            </div>

            <a href="{{ route('recibos.print-all', ['localidad' => $localidadId,'inicio' => $inicioSemana,'fin' => $finSemana,'tipo' => $tipoSemana,]) }}"
                target="_blank"
                class="btn btn-sm">
                <i class="fa-solid fa-print"></i>
                Imprimir todos los recibos
            </a>

        </div>
    </div>

    <!-- Rotulo de la semana -->
    <div class="flex gap-2 mb-2">
        <h2 class="card-title font-bold">{{ $this->tituloSemana }}
            <i class="fa-solid fa-circle-check text-green-600"></i>
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ($productores as $productor)

        <div class="card bg-base-100 shadow border border-gray-600">

            <div class="card-body">

                <div class="uppercase font-bold">
                    <i class="fa-solid fa-location-dot text-green-700 dark:text-green-500"></i>
                    {{ $productor->localidad->nombre }}
                </div>

                <h2 class="card-title">
                    <i class="fa-regular fa-calendar-days"></i>
                    {{ $this->tituloSemana }}
                </h2>

                <h2 class="card-title font-bold">
                    <i class="fa-solid fa-user"></i>
                    {{ $productor->nombre }}
                </h2>

                <table class="table-auto border">

                    <thead>

                        <tr class="bg-green-700 text-white">
                            <th class="border border-gray-300">Día</th>
                            <th class="border border-gray-300">Litros</th>
                            <th class="border border-gray-300">Córdobas</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($productor->acopios as $acopio)

                        <tr class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-700' : 'bg-gray-200 dark:bg-gray-800' }}">

                            <td class="border border-gray-300 dark:border-gray-600">
                                {{ \Carbon\Carbon::parse($acopio->fecha)->locale('es')->translatedFormat('D d') }}
                            </td>

                            <td class="text-center border border-gray-300 dark:border-gray-600">
                                {{ number_format($acopio->litros, 0) }}
                            </td>

                            <td class="text-right border border-gray-300 dark:border-gray-600">
                                C$ {{ number_format($acopio->total, 0) }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                    <tfoot>

                        <tr class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-700' : 'bg-gray-200 dark:bg-gray-800' }}">

                            <th class="border border-gray-300 text-left">Totales</th>

                            <th class="border border-gray-300 text-center">
                                {{ number_format($productor->totales_recibo['litros'], 0) }}
                            </th>

                            <th class="border border-gray-300 text-right">
                                C$ {{ number_format($productor->totales_recibo['cordobas'], 0) }}
                            </th>

                        </tr>

                        <tr class="odd:bg-gray-100 even:bg-gray-200 dark:odd:bg-gray-700 dark:even:bg-gray-800">
                            <th colspan="2">% Deducción por compra</th>

                            <th class="border border-gray-300 text-right">
                                C$ {{ number_format( $productor->totales_recibo['porcentaje_deduccion'], 0 ) }}
                            </th>
                        </tr>

                        <tr class="odd:bg-gray-100 even:bg-gray-200 dark:odd:bg-gray-700 dark:even:bg-gray-800">
                            <th colspan="2" class="border border-gray-300">Anticipos / Adelantos</th>

                            <th class="border border-gray-300 text-right">
                                C$ {{ number_format( $productor->totales_recibo['otras_deducciones'], 0 ) }}
                            </th>
                        </tr>

                        <tr class="odd:bg-gray-100 even:bg-gray-200 dark:odd:bg-gray-700 dark:even:bg-gray-800">
                            <th colspan="2" class="border border-gray-300">Neto a recibir</th>

                            <th class="border border-gray-300 text-right">
                                C$ {{ number_format( $productor->totales_recibo['neto'], 0 ) }}
                            </th>
                        </tr>

                    </tfoot>

                </table>

                <div class="mt-2">

                    <a role="button" href="{{ route('recibos.print',['productor' => $productor->id,'inicio' => $inicioSemana,'fin' => $finSemana,'tipo' => $tipoSemana,]) }}" target="_blank"
                        class="btn btn-xs btn-outline text-black bg-gray-200 dark:bg-gray-700 dark:text-white">
                        <i class="fa-solid fa-print"></i>
                        Imprimir recibo
                    </a>

                </div>

            </div>

        </div>



        @endforeach
    </div>


    <div class="mt-6">
        {{ $productores->links() }}
    </div>



</div>