<?php

namespace App\Livewire\Acopio;

use Carbon\Carbon;
use Carbon\CarbonInterface;


use Livewire\Component;
use App\Models\Localidad;
use App\Models\Productor;

class Acopio extends Component
{
    public $fechas = [];
    public $localidades;
    public $localidadId;
    public $localidad;
    public $tipoSemana;
    public $inicioSemana;
    public $finSemana;
    public $fechaReporte;

    protected $queryString = [
        'localidadId',
        'tipoSemana',
        'fechaReporte'
    ];

    public function mount()
    {
        Carbon::setLocale('es');

        $this->localidades = Localidad::orderBy('nombre')->get();

        // Primera localidad por defecto
        $this->localidadId ??= $this->localidades->first()?->id;

        // Semana A por defecto
        $this->tipoSemana ??= 'A';

        $this->fechaReporte ??= now()->toDateString();

        // Generar fechas
        $this->calcularSemana();
    }

    public function calcularSemana()
    {
        Carbon::setLocale('es');

        $fecha = Carbon::parse($this->fechaReporte);

        if ($this->tipoSemana === 'A') {

            // Domingo → Sábado
            $inicio = $fecha->copy()->startOfWeek(Carbon::SUNDAY);
        } else {

            // Viernes → Jueves
            $inicio = $fecha->copy()->startOfWeek(Carbon::FRIDAY);
        }

        $this->inicioSemana = $inicio;
        $this->finSemana = $inicio->copy()->addDays(6);

        $this->fechas = [];

        for ($i = 0; $i < 7; $i++) {
            $this->fechas[] = $inicio->copy()
                ->addDays($i)
                ->locale('es');
        }
    }

    public function getProductoresProperty()
    {
        return cache()->remember(
            'productores_' . $this->localidadId . '_' . $this->tipoSemana . '_' . $this->inicioSemana->format('Ymd'),
            5,
            fn() => Productor::with(['acopios' => function ($q) {
                $q->whereBetween('fecha', [
                    $this->inicioSemana,
                    $this->finSemana
                ]);
            }])
                ->where('activo', true)
                ->where('localidad_id', $this->localidadId)
                ->where('semana', $this->tipoSemana)
                ->orderBy('nombre')
                ->get()
        );
    }

    public function updatedTipoSemana()
    {
        cache()->flush();
        $this->calcularSemana();
    }

    public function updatedFechaReporte()
    {
        cache()->flush();
        $this->calcularSemana();
    }

    public function getAcopiosMapProperty()
    {
        $map = [];
        foreach ($this->productores as $productor) {
            foreach ($productor->acopios as $acopio) {
                $map[$productor->id][$acopio->fecha] = $acopio;
            }
        }
        return $map;
    }

    public function guardar() {}

    public function render()
    {
        return view('livewire.acopio.acopio');
    }
}
