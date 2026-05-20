<?php

namespace App\Livewire\Acopio;

use Carbon\Carbon;
use App\Models\Acopio;
use App\Models\Localidad;
use Livewire\Component;
use App\Models\TotalesAcopio;

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

    public function getRecibidoAcopioProperty()
    {
        $rows = TotalesAcopio::selectRaw('
            localidad_id,
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

    public function getLitrosPerdidosProperty()
    {
        $data = [];

        foreach ($this->localidades as $localidad) {

            foreach ($this->fechas as $fecha) {

                $campo = $this->recibidoCampo[$localidad->id][$fecha] ?? 0;

                $acopio = $this->recibidoAcopio[$localidad->id][$fecha] ?? 0;

                $data[$localidad->id][$fecha] = $campo - $acopio;
            }
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

    public function render()
    {
        return view('livewire.acopio.resumen-semanal');
    }
}
