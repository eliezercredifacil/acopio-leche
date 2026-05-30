<?php

namespace App\Livewire\Acopio;

use Carbon\Carbon;
use App\Models\Acopio;
use App\Models\Localidad;
use Livewire\Component;
use App\Models\TotalesAcopio;
use App\Models\Deduction;

class ResumenSemanal extends Component
{
    public $tipoSemana = 'A';

    public $fechaReporte;

    public $inicioSemana;

    public $finSemana;

    public $fechas = [];

    protected $queryString = [

        'tipoSemana',

        'fechaReporte',
    ];

    public function mount()
    {
        $this->fechaReporte ??= now()->toDateString();

        $this->calcularSemana();
    }

    public function updatedTipoSemana()
    {
        $this->calcularSemana();
    }

    public function updatedFechaReporte()
    {
        $this->calcularSemana();
    }

    public function calcularSemana()
    {
        $fecha = Carbon::parse($this->fechaReporte);

        if ($this->tipoSemana === 'A') {

            $inicio = $fecha->copy()->startOfWeek(Carbon::SUNDAY);
        } else {

            $inicio = $fecha->copy()->startOfWeek(Carbon::FRIDAY);
        }

        $this->inicioSemana = $inicio->toDateString();

        $this->finSemana = $inicio->copy()->addDays(6)->toDateString();

        $this->fechas = [];

        for ($i = 0; $i < 7; $i++) {

            $this->fechas[] = $inicio->copy()->addDays($i)->toDateString();
        }
    }

    public function getTituloSemanaProperty()
    {
        Carbon::setLocale('es');

        $inicio = Carbon::parse($this->inicioSemana);
        $fin = Carbon::parse($this->finSemana);

        if ($inicio->month === $fin->month) {

            return sprintf(
                'Semana del %s al %s de %s',
                $inicio->format('d'),
                $fin->format('d'),
                $fin->translatedFormat('F')
            );
        }

        return sprintf(
            'Semana del %s de %s al %s de %s',
            $inicio->format('d'),
            $inicio->translatedFormat('F'),
            $fin->format('d'),
            $fin->translatedFormat('F')
        );
    }

    public function getRecibidoCampoProperty()
    {
        $rows = Acopio::selectRaw('localidad_id,fecha,SUM(litros) as total_litros')

            ->whereBetween('fecha', [
                $this->inicioSemana,
                $this->finSemana
            ])

            ->where(
                'tipo_semana',
                $this->tipoSemana
            )

            ->groupBy(
                'localidad_id',
                'fecha'
            )

            ->get();

        $data = [];

        foreach ($rows as $row) {

            $data[$row->localidad_id][$row->fecha] =
                $row->total_litros;
        }

        return $data;
    }

    public function getLocalidadesProperty()
    {
        return Localidad::orderBy('nombre')
            ->get();
    }

    public function getTotalSemanalCampoProperty()
    {
        $data = [];

        foreach ($this->localidades as $localidad) {

            $total = 0;

            foreach ($this->fechas as $fecha) {

                $total += $this->recibidoCampo[$localidad->id][$fecha] ?? 0;
            }

            $data[$localidad->id] = $total;
        }

        return $data;
    }

    public function getTotalesDiariosCampoProperty()
    {
        return Acopio::selectRaw('
            fecha,
            SUM(litros) as total_litros
        ')

            ->whereBetween('fecha', [
                $this->inicioSemana,
                $this->finSemana
            ])

            ->where(
                'tipo_semana',
                $this->tipoSemana
            )

            ->groupBy('fecha')

            ->pluck('total_litros', 'fecha')

            ->toArray();
    }

    public function getTotalSemanaCampoProperty()
    {
        return collect($this->totalesDiariosCampo)
            ->sum();
    }

    public function getTotalSemanalCordobasProperty()
    {
        $rows = Acopio::selectRaw('
            localidad_id,
            SUM(total) as total_cordobas
        ')

            ->whereBetween('fecha', [
                $this->inicioSemana,
                $this->finSemana
            ])

            ->where(
                'tipo_semana',
                $this->tipoSemana
            )

            ->groupBy('localidad_id')

            ->get();

        $data = [];

        foreach ($rows as $row) {

            $data[$row->localidad_id] =
                $row->total_cordobas;
        }

        return $data;
    }

    public function getTotalGeneralCordobasProperty()
    {
        return collect($this->totalSemanalCordobas)->sum();
    }

    public function getPorcentajeDeduccionProperty()
    {
        $data = [];

        foreach ($this->totalSemanalCordobas as $localidadId => $total) {

            $data[$localidadId] = $total * 0.013;
        }

        return $data;
    }

    public function getTotalGeneralPorcentajeDeduccionProperty()
    {
        return collect($this->porcentajeDeduccion)
            ->sum();
    }

    public function getDeduccionesProperty()
    {
        $rows = Deduction::selectRaw('
            localidad_id,
            tipo,
            SUM(monto) as total
        ')

            ->where(
                'semana_inicio',
                $this->inicioSemana
            )

            ->groupBy(
                'localidad_id',
                'tipo'
            )

            ->get();

        $data = [];

        foreach ($rows as $row) {

            $data[$row->localidad_id][$row->tipo] =
                $row->total;
        }

        return $data;
    }

    public function totalGeneralDeduccion($tipo)
    {
        return collect($this->deducciones)

            ->sum(function ($tipos) use ($tipo) {

                return $tipos[$tipo] ?? 0;
            });
    }

    public function getTotalSemanalDeduccionesProperty()
    {
        $data = [];

        foreach ($this->localidades as $localidad) {

            $deducciones = $this->deducciones[$localidad->id] ?? [];

            $manuales = collect($deducciones)->sum();

            $porcentaje = $this->porcentajeDeduccion[$localidad->id] ?? 0;

            $data[$localidad->id] = $manuales + $porcentaje;
        }

        return $data;
    }

    public function getTotalGeneralDeduccionesProperty()
    {
        return collect($this->totalSemanalDeducciones)
            ->sum();
    }

    public function getNetoSemanalProperty()
    {
        $data = [];

        foreach ($this->localidades as $localidad) {

            $cordobas = $this->totalSemanalCordobas[$localidad->id] ?? 0;

            $deducciones = $this->totalSemanalDeducciones[$localidad->id] ?? 0;

            $data[$localidad->id] = $cordobas - $deducciones;
        }

        return $data;
    }

    public function getTotalGeneralNetoProperty()
    {
        return collect($this->netoSemanal)
            ->sum();
    }

    public function getTotalesDiariosAcopioProperty()
    {
        return TotalesAcopio::selectRaw('
            fecha,
            SUM(litros) as total_litros
        ')

            ->whereBetween('fecha', [
                $this->inicioSemana,
                $this->finSemana
            ])

            ->where(
                'tipo_semana',
                $this->tipoSemana
            )

            ->groupBy('fecha')

            ->pluck('total_litros', 'fecha')

            ->toArray();
    }

    public function getTotalSemanaAcopioProperty()
    {
        return collect($this->totalesDiariosAcopio)
            ->sum();
    }

    public function getLitrosPerdidosProperty()
    {
        $data = [];

        foreach ($this->fechas as $fecha) {

            $campo = $this->totalesDiariosCampo[$fecha] ?? 0;

            $acopio = $this->totalesDiariosAcopio[$fecha] ?? 0;

            $data[$fecha] = $campo - $acopio;
        }

        return $data;
    }

    public function getTotalSemanaLitrosPerdidosProperty()
    {
        return collect($this->litrosPerdidos)
            ->sum();
    }

    public function getPorcentajeLitrosPerdidosProperty()
    {
        $data = [];

        foreach ($this->fechas as $fecha) {

            $campo = $this->totalesDiariosCampo[$fecha] ?? 0;

            $perdidos = $this->litrosPerdidos[$fecha] ?? 0;

            $data[$fecha] = $campo > 0 ? ($perdidos / $campo) * 100 : 0;
        }

        return $data;
    }

    public function getTotalSemanaPorcentajePerdidoProperty()
    {
        $campo = $this->totalSemanaCampo;

        $perdidos = $this->totalSemanaLitrosPerdidos;

        return $campo > 0 ? ($perdidos / $campo) * 100 : 0;
    }

    public function render()
    {
        return view('livewire.acopio.resumen-semanal');
    }
}
