<div class="titulo">

    <i class="fa-solid fa-location-dot"></i>
    {{ strtoupper($productor->localidad->nombre) }}

</div>

<div class="subtitulo">

    <i class="fa-regular fa-calendar-days"></i>
    {{ $tituloSemana }}

</div>

<div class="subtitulo">

    <i class="fa-solid fa-user"></i>
    {{ $productor->nombre }}

</div>

<table>

    <thead>

        <tr>

            <th>Día</th>

            <th>Litros</th>

            <th>Córdobas</th>

        </tr>

    </thead>

    <tbody>

        @foreach($productor->acopios as $acopio)

        <tr>

            <td>
                {{ \Carbon\Carbon::parse($acopio->fecha)->locale('es')->translatedFormat('D d') }}
            </td>

            <td class="text-center">
                {{ number_format($acopio->litros,0) }}
            </td>

            <td class="text-left">
                C$ {{ number_format($acopio->total,0) }}
            </td>

        </tr>

        @endforeach

        <tr class="font-bold">

            <td>Totales</td>

            <td class="text-center">
                {{ number_format($productor->totales_recibo['litros'],0) }}
            </td>

            <td class="text-center">
                C$ {{ number_format($productor->totales_recibo['cordobas'],0) }}
            </td>

        </tr>

        <tr>

            <td colspan="2">
                % Deducción por compra
            </td>

            <td class="text-right">
                C$ {{ number_format($productor->totales_recibo['porcentaje_deduccion'],0) }}
            </td>

        </tr>

        <tr>

            <td colspan="2">
                Anticipos / Adelantos
            </td>

            <td class="text-right">
                C$ {{ number_format($productor->totales_recibo['otras_deducciones'],0) }}
            </td>

        </tr>

        <tr class="font-bold">

            <td colspan="2">
                Neto a recibir
            </td>

            <td class="text-right">
                C$ {{ number_format($productor->totales_recibo['neto'],0) }}
            </td>

        </tr>

    </tbody>

</table>