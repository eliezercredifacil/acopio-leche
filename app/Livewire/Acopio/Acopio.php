<?php

namespace App\Livewire\Acopio;

use Carbon\Carbon;
use Livewire\Component;

use App\Models\Localidad;
use App\Models\Productor;
use App\Models\Acopio as AcopioModel;

class Acopio extends Component
{
    public $fechas = [];

    public $localidades;

    public $localidadId;

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
        $this->localidades = Localidad::orderBy('nombre')->get();

        // Primera localidad por defecto
        $this->localidadId ??= $this->localidades->first()?->id;

        // Semana A por defecto
        $this->tipoSemana ??= 'A';

        // Fecha actual por defecto
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

    public function updatedLocalidadId()
    {
        $this->calcularSemana();
    }

    public function calcularSemana()
    {
        $fecha = Carbon::parse($this->fechaReporte);

        if ($this->tipoSemana === 'A') {

            // Domingo → Sábado
            $inicio = $fecha->copy()
                ->startOfWeek(Carbon::SUNDAY);
        } else {

            // Viernes → Jueves
            $inicio = $fecha->copy()
                ->startOfWeek(Carbon::FRIDAY);
        }

        $this->inicioSemana = $inicio->toDateString();

        $this->finSemana = $inicio->copy()
            ->addDays(6)
            ->toDateString();

        $this->fechas = [];

        for ($i = 0; $i < 7; $i++) {

            $this->fechas[] = $inicio->copy()
                ->addDays($i)
                ->toDateString();
        }
    }

    public function getProductoresProperty()
    {
        return cache()->remember(
            $this->cacheKey(),
            5,
            fn() => Productor::with([
                'acopios' => function ($q) {

                    $q->whereBetween('fecha', [
                        $this->inicioSemana,
                        $this->finSemana
                    ]);
                }
            ])
                ->where('activo', true)
                ->where('localidad_id', $this->localidadId)
                ->where('semana', $this->tipoSemana)
                ->orderBy('nombre')
                ->get()
        );
    }

    public function cacheKey()
    {
        return 'productores_' .
            $this->localidadId . '_' .
            $this->tipoSemana . '_' .
            $this->inicioSemana;
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

    public function getResumenProperty()
    {
        $data = [];

        foreach ($this->productores as $productor) {

            $totalLitros = $productor->acopios->sum('litros');

            $totalCordobas = $productor->acopios->sum('total');

            $precioLitro = $productor->precio_litro;

            $deduccion = $totalCordobas * 0.013;

            $neto = $totalCordobas - $deduccion;

            $data[$productor->id] = [

                'litros' => $totalLitros,

                'precio' => $precioLitro,

                'cordobas' => $totalCordobas,

                'deduccion' => $deduccion,

                'neto' => $neto,
            ];
        }

        return $data;
    }

    public function guardar($productorId, $fecha, $precio_litro, $litros)
    {
        $litros = (float) $litros;

        AcopioModel::updateOrCreate(
            [
                'productor_id' => $productorId,
                'fecha' => $fecha,
            ],
            [
                'localidad_id' => $this->localidadId,
                'litros' => $litros,
                'precio' => $precio_litro ?? 0,
                'total' => $litros * $precio_litro
            ]
        );

        cache()->forget($this->cacheKey());
    }

    public function render()
    {
        return view('livewire.acopio.acopio');
    }
}
