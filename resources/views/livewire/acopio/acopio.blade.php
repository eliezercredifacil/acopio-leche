<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="mb-3 relative max-w-sm">
        <input type="date" class="input bg-base-100" wire:model.lazy="fechaReporte" />

        {{-- Spinner global --}}
        <div wire:loading.delay wire:target="fechaReporte">
            <span class="loading loading-spinner loading-md"></span>
        </div>
    </div>

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

        </div>

    </div>


    <!-- Tabla de acopios -->
    <div class="overflow-x-auto">

        <table class="table min-w-full border-collapse">

            <thead>
                <tr>
                    <th class="bg-cyan-800 text-white border border-gray-300">PRODUCTORES</th>

                    @foreach ($fechas as $fecha)
                    <th class="bg-lime-700 text-white border text-center border-gray-300">
                        {{ \Carbon\Carbon::parse($fecha)->locale('es')->translatedFormat('D d') }}
                    </th>
                    @endforeach

                    <th class="border border-gray-300 bg-lime-900 text-white">Total Litros</th>
                    <th class="border border-gray-300 bg-yellow-700 text-white">Precio litro</th>
                    <th class="border border-gray-300 bg-lime-900 text-white">Total córdobas</th>
                    <th class="border border-gray-300 bg-red-900 text-white">% Deducción</th>

                    @foreach ($tipos as $tipo)

                    <th class="border border-gray-300 text-center bg-cyan-900 text-white">

                        {{ ucfirst($tipo) }}

                    </th>

                    @endforeach

                    <th class="border border-gray-300 bg-red-900 text-white">Deducciones</th>
                    <th class="border border-gray-300 bg-green-900 text-white">Neto a recibir</th>
                </tr>
            </thead>

            @foreach ($this->productores as $productor)
            <tr>
                <td class="bg-gray-600 text-white sticky left-0 z-10 border border-gray-300 whitespace-nowrap font-bold">{{ $productor->nombre }}</td>

                @foreach ($fechas as $fecha)
                @php
                $acopio = $this->acopiosMap[$productor->id][$fecha] ?? null;
                @endphp

                <td class="border border-gray-300 p-0 text-center" wire:key="celda-{{ $productor->id }}-{{ $fecha }}-{{ $tipoSemana }}"
                    title="Precio del dia: C$ {{ number_format($acopio?->precio ?? 0, 2) }}">

                    <div x-data="{ editing: false, litros: '{{ $acopio ? rtrim(rtrim($acopio->litros, '0'), '.') : '' }}' }" class="w-full h-full">

                        {{-- MODO TEXTO --}}
                        <div
                            x-show="!editing"
                            @click="editing = true; $nextTick(() => { $refs.litros.focus(); $refs.litros.select(); });"
                            class="cursor-pointer h-8 flex items-center justify-center hover:bg-base-200">
                            <span x-text="litros || ''"></span>
                        </div>

                        {{-- MODO INPUT --}}
                        <input x-show="editing" x-ref="litros" x-model="litros"
                            @keydown.enter="editing = false; $wire.guardar( '{{ $productor->id }}', '{{ $fecha }}', '{{ $productor->precio_litro }}', litros )"
                            @blur="editing = false; $wire.guardar( '{{ $productor->id }}', '{{ $fecha }}', '{{ $productor->precio_litro }}', litros )"
                            type="number"
                            class="w-full h-8 text-center border-none focus:outline-none bg-base-100" />

                    </div>
                </td>

                @endforeach

                <td class="border border-gray-300 text-sm text-center font-semibold">
                    {{ $this->resumen[$productor->id]['litros'] ?? 0 }}
                </td>

                <td class="border border-gray-300 text-sm text-center font-semibold">
                    C$ {{ $this->resumen[$productor->id]['precio'] ?? 0 }}
                </td>

                <td class="border border-gray-300 text-sm text-center font-semibold">
                    C$ {{ number_format($this->resumen[$productor->id]['cordobas']) ?? 0 }}
                </td>

                <td class="border border-gray-300 text-sm text-center font-semibold">
                    C$ {{ number_format($this->resumen[$productor->id]['porcentaje_compra']) ?? 0 }}
                </td>

                @foreach ($tipos as $tipo)
                <td class="border border-gray-300 text-center" wire:key="deduction-{{ $tipo }}-{{ $productor->id }}-{{ $inicioSemana }}">

                    <div x-data="{ editing: false, monto: '{{ $this->resumen[$productor->id][$tipo] ?? '' }}' }" class="w-full h-full">

                        {{-- TEXTO --}}
                        <div
                            class="cursor-pointer h-8 flex items-center justify-center hover:bg-base-200"
                            x-show="!editing"
                            @click="editing = true; $nextTick(() => { $refs.inputMonto.focus(); $refs.inputMonto.select(); });">
                            <span x-text="monto || '-'"></span>
                        </div>

                        {{-- INPUT --}}
                        <input type="number" x-show="editing" x-ref="inputMonto" x-model="monto"
                            @keydown.enter="editing = false; $wire.guardarDeduccion('{{ $productor->id }}','{{ $tipo }}',monto)"
                            @blur="editing = false; $wire.guardarDeduccion('{{ $productor->id }}','{{ $tipo }}',monto)"
                            class="w-full h-8 text-center border-none focus:outline-none bg-base-100" />

                    </div>
                </td>


                @endforeach

                <td class="border border-gray-300 text-sm text-center font-semibold">
                    C$ {{ number_format($this->resumen[$productor->id]['deducciones']) ?? 0 }}
                </td>
                <td class="border border-gray-300 text-sm text-center font-semibold">
                    C$ {{ number_format($this->resumen[$productor->id]['neto']) ?? 0 }}
                </td>
            </tr>
            @endforeach

        </table>

    </div>


</div>