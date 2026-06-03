<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor;
use Carbon\Carbon;

class ReciboController extends Controller
{
    public function print(Productor $productor, Request $request)
    {

        $inicioSemana = $request->inicio;
        $finSemana = $request->fin;
        $tipoSemana = $request->tipo;

        $productor->load([

            'localidad',

            'acopios' => function ($q) use (
                $inicioSemana,
                $finSemana,
                $tipoSemana
            ) {

                $q->whereBetween('fecha', [
                    $inicioSemana,
                    $finSemana
                ])

                    ->where(
                        'tipo_semana',
                        $tipoSemana
                    )

                    ->orderBy('fecha');
            },

            'deductions' => function ($q) use (
                $inicioSemana
            ) {

                $q->where(
                    'semana_inicio',
                    $inicioSemana
                );
            }
        ]);

        $inicio = Carbon::parse($inicioSemana)->locale('es');
        $fin = Carbon::parse($finSemana)->locale('es');

        if ($inicio->month === $fin->month) {

            $tituloSemana = sprintf(
                'Semana del %s al %s de %s',
                $inicio->format('d'),
                $fin->format('d'),
                $fin->translatedFormat('F')
            );
        } else {

            $tituloSemana = sprintf(
                'Semana del %s de %s al %s de %s',
                $inicio->format('d'),
                $inicio->translatedFormat('F'),
                $fin->format('d'),
                $fin->translatedFormat('F')
            );
        }

        return view('acopio.recibos-print', compact('productor', 'inicioSemana', 'finSemana', 'tipoSemana', 'tituloSemana'));
    }


    public function printAll(Request $request)
    {
        $localidadId = $request->localidad;

        $inicioSemana = $request->inicio;

        $finSemana = $request->fin;

        $tipoSemana = $request->tipo;

        $productores = Productor::with([

            'localidad',

            'acopios' => function ($q) use (
                $inicioSemana,
                $finSemana,
                $tipoSemana
            ) {

                $q->whereBetween('fecha', [
                    $inicioSemana,
                    $finSemana
                ])

                    ->where(
                        'tipo_semana',
                        $tipoSemana
                    )

                    ->orderBy('fecha');
            },

            'deductions' => function ($q) use (
                $inicioSemana
            ) {

                $q->where(
                    'semana_inicio',
                    $inicioSemana
                );
            }

        ])

            ->where('activo', true)

            ->where(
                'localidad_id',
                $localidadId
            )

            ->where(
                'semana',
                $tipoSemana
            )

            ->orderBy('nombre')

            ->get();

        $inicio = Carbon::parse($inicioSemana)->locale('es');
        $fin = Carbon::parse($finSemana)->locale('es');

        if ($inicio->month === $fin->month) {

            $tituloSemana = sprintf(
                'Semana del %s al %s de %s',
                $inicio->format('d'),
                $fin->format('d'),
                $fin->translatedFormat('F')
            );
        } else {

            $tituloSemana = sprintf(
                'Semana del %s de %s al %s de %s',
                $inicio->format('d'),
                $inicio->translatedFormat('F'),
                $fin->format('d'),
                $fin->translatedFormat('F')
            );
        }

        return view('acopio.recibos-print-all',compact('productores','tituloSemana','inicioSemana','finSemana','tipoSemana'));
        
    }
}
