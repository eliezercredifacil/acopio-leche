<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    <div class="flex flex-wrap gap-2 mb-4">
        <input type="date" class="input bg-base-100 flex-none w-40" wire:model.lazy="fechaReporte" />

        {{-- Spinner global --}}
        <div wire:loading.delay wire:target="fechaReporte">
            <span class="loading loading-spinner loading-md"></span>
        </div>

        <!-- Botones para seleccionar tipo de semana -->
        <select class="select appearance-none bg-base-100 flex-none w-48" wire:model.live="tipoSemana">
            <option value="" disabled>Seleccionar Grupo</option>
            <option value="B"> Viernes a Jueves </option>
            <option value="A"> Domingo a Sábado </option>
        </select>

        {{-- Spinner global --}}
        <div wire:loading.delay wire:target="tipoSemana">
            <span class="loading loading-spinner loading-md"></span>
        </div>
    </div>

    <!-- Rotulo de la semana -->
    <div class="flex gap-2 mb-2">
        <h2 class="card-title font-bold">{{ $this->tituloSemana }}
            <i class="fa-solid fa-circle-check text-green-600"></i>
        </h2>
    </div>

    <div class="overflow-x-auto">

        <table class="table min-w-full border-collapse">

            <tr>
                <th class="bg-cyan-800 text-white border border-gray-300 w-auto whitespace-nowrap">COMARCAS</th>
                @foreach ($fechas as $fecha)
                <th class="bg-cyan-800 text-white border border-gray-300 text-center w-auto whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($fecha)->locale('es')->translatedFormat('D d') }}
                </th>
                @endforeach
                <th class="bg-cyan-800 text-white border border-gray-300 text-center whitespace-nowrap">Total entregados</th>
                <th class="bg-cyan-800 text-white border border-gray-300 text-center whitespace-nowrap">Total cordobas</th>
                <th class="bg-red-800 text-white border border-gray-300 text-center whitespace-nowrap">% Deducción</th>
                <th class="bg-red-800 text-white border border-gray-300 text-center whitespace-nowrap">Efectivo</th>
                <th class="bg-red-800 text-white border border-gray-300 text-center whitespace-nowrap">Combustible</th>
                <th class="bg-red-800 text-white border border-gray-300 text-center whitespace-nowrap">Alimentos</th>
                <th class="bg-red-800 text-white border border-gray-300 text-center whitespace-nowrap">Lácteos</th>
                <th class="bg-red-800 text-white border border-gray-300 text-center whitespace-nowrap">Otros</th>
                <th class="bg-cyan-800 text-white border border-gray-300 text-center whitespace-nowrap">Total Deducciones</th>
                <th class="bg-cyan-800 text-white border border-gray-300 text-center whitespace-nowrap">Neto a recibir</th>
            </tr>

            @foreach ($this->localidades as $localidad)

            <tr>

                {{-- LOCALIDAD --}}
                <td class="bg-green-800 text-white border border-gray-300 font-bold uppercase whitespace-nowrap">

                    {{ $localidad->nombre }}

                </td>

                {{-- DÍAS --}}
                @foreach ($fechas as $fecha)

                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    {{ number_format($this->RecibidoCampo[$localidad->id][$fecha] ?? 0, 0 ) }}
                </td>

                @endforeach

                {{-- TOTAL --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    {{ number_format($this->TotalSemanalCampo[$localidad->id], 0) }}
                </td>

                {{-- TOTAL CORDOBAS --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->totalSemanalCordobas[$localidad->id] ?? 0, 0) }}
                </td>

                {{-- PORCENTAJE DEDUCCIÓN --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->porcentajeDeduccion[$localidad->id] ?? 0, 0) }}
                </td>

                {{-- EFECTIVO --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->deducciones[$localidad->id]['efectivo'] ?? 0, 0) }}
                </td>

                {{-- COMBUSTIBLE --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->deducciones[$localidad->id]['combustible'] ?? 0, 0) }}
                </td>

                {{-- ALIMENTOS --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->deducciones[$localidad->id]['alimentos'] ?? 0, 0) }}
                </td>

                {{-- LACTEOS --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->deducciones[$localidad->id]['lacteos'] ?? 0, 0) }}
                </td>

                {{-- OTROS --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->deducciones[$localidad->id]['otros'] ?? 0, 0) }}
                </td>

                {{-- TOTAL DEDUCCIONES --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->totalSemanalDeducciones[$localidad->id] ?? 0, 0) }}
                </td>

                {{-- NETO A RECIBIR --}}
                <td class="text-center border border-gray-300 font-bold bg-slate-700 text-white dark:bg-slate-800 dark:text-gray-200">
                    C$ {{ number_format($this->netoSemanal[$localidad->id] ?? 0, 0) }}
                </td>

            </tr>

            @endforeach

            <tr class="bg-base-200">

                <td class="font-semibold border border-gray-300">Recibido en campo</td>

                @foreach ($fechas as $fecha)
                <td class="text-center border border-gray-300">
                    {{ number_format( $this->TotalesDiariosCampo[$fecha] ?? 0, 0 ) }}
                </td>
                @endforeach

                {{-- TOTAL SEMANAL --}}
                <td class="text-center border border-gray-300">
                    {{ number_format(  $this->TotalSemanaCampo, 0 ) }}
                </td>

                {{-- TOTAL DE TODAS LAS SEMANAS --}}
                <td class="text-center font-bold text-success border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralCordobas, 0 ) }}
                </td>

                <td class="text-center font-bold text-error border border-gray-300">
                    C$ {{ number_format( $this->TotalGeneralPorcentajeDeduccion, 0 ) }}
                </td>

                <td class="text-center font-bold text-error border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralDeduccion('efectivo'), 0 ) }}
                </td>

                <td class="text-center font-bold text-error border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralDeduccion('combustible'), 0 ) }}
                </td>

                <td class="text-center font-bold text-error border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralDeduccion('alimentos'), 0 ) }}
                </td>

                <td class="text-center font-bold text-error border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralDeduccion('lacteos'), 0 ) }}
                </td>

                <td class="text-center font-bold text-error border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralDeduccion('otros'), 0 ) }}
                </td>

                <td class="text-center font-bold text-error border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralDeducciones, 0 ) }}
                </td>

                <td class="text-center font-bold text-success border border-gray-300">
                    C$ {{ number_format( $this->totalGeneralNeto, 0 ) }}
                </td>

            </tr>

            <tr>
                <td class="font-bold border border-gray-300">
                    Recibido en Acopio
                </td>

                @foreach ($fechas as $fecha)
                <td class="font-bold border border-gray-300 text-center">
                    {{ number_format( $this->totalesDiariosAcopio[$fecha] ?? 0, 0 ) }}
                </td>
                @endforeach

                <td class="font-bold border border-gray-300 text-center">
                    {{ number_format( $this->totalSemanaAcopio, 0 ) }}
                </td>
            </tr>

            <tr>
                <td class="font-bold border border-gray-300">
                    Litros perdidos
                </td>

                @foreach ($fechas as $fecha)
                <td class="font-bold border border-gray-300 text-center">
                    {{ number_format( $this->litrosPerdidos[$fecha] ?? 0, 0 ) }}
                </td>
                @endforeach

                <td class="font-bold border border-gray-300 text-center">
                    {{ number_format( $this->totalSemanaLitrosPerdidos, 0 ) }}
                </td>
            </tr>

            <tr>
                <td class="font-bold border border-gray-300">
                    % Perdidos
                </td>

                @foreach ($fechas as $fecha)

                <td class="text-center border border-gray-300">
                    {{ number_format( $this->porcentajeLitrosPerdidos[$fecha] ?? 0, 2 ) }}%
                </td>

                @endforeach

                <td class="text-center border border-gray-300">
                    {{ number_format( $this->totalSemanaPorcentajePerdido, 2 ) }}%
                </td>


            </tr>


        </table>

    </div>

</div>