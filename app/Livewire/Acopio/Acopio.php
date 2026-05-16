<?php

namespace App\Livewire\Acopio;

use Carbon\Carbon;
use Livewire\Component;

use App\Models\Localidad;
use App\Models\Productor;
use App\Models\Acopio as AcopioModel;
use App\Models\Deduction;

class Acopio extends Component
{
    public $fechas = [];

    public $localidades;

    public $localidadId;

    public $tipoSemana;

    public $inicioSemana;

    public $finSemana;

    public $fechaReporte;

    public $tipos = ['efectivo', 'combustible', 'alimentos', 'lacteos', 'otros'];

    protected $queryString = ['localidadId', 'tipoSemana', 'fechaReporte'];

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
                },

                'deductions' => function ($q) {

                    $q->where('semana_inicio', $this->inicioSemana);
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

            // =========================
            // ACOPIOS
            // =========================

            $totalLitros = $productor->acopios
                ->sum('litros');

            $totalCordobas = $productor->acopios
                ->sum('total');

            $precioLitro = $productor->precio_litro;

            // =========================
            // % DEDUCCIÓN COMPRA
            // =========================

            $porcentajeCompra =
                $totalCordobas * 0.013;

            // =========================
            // DEDUCCIONES
            // =========================

            $efectivo = $productor->deductions
                ->where('tipo', 'efectivo')
                ->sum('monto');

            $combustible = $productor->deductions
                ->where('tipo', 'combustible')
                ->sum('monto');

            $alimentos = $productor->deductions
                ->where('tipo', 'alimentos')
                ->sum('monto');

            $lacteos = $productor->deductions
                ->where('tipo', 'lacteos')
                ->sum('monto');

            $otros = $productor->deductions
                ->where('tipo', 'otros')
                ->sum('monto');

            // =========================
            // TOTAL DEDUCCIONES
            // =========================

            $totalDeducciones =
                $porcentajeCompra +
                $efectivo +
                $combustible +
                $alimentos +
                $lacteos +
                $otros;

            // =========================
            // NETO
            // =========================

            $neto =
                $totalCordobas -
                $totalDeducciones;

            // =========================
            // RESUMEN FINAL
            // =========================

            $data[$productor->id] = [

                // ACOPIOS
                'litros' => $totalLitros,

                'precio' => $precioLitro,

                'cordobas' => $totalCordobas,

                // DEDUCCIÓN %
                'porcentaje_compra' => $porcentajeCompra,

                // DEDUCCIONES
                'efectivo' => $efectivo,

                'combustible' => $combustible,

                'alimentos' => $alimentos,

                'lacteos' => $lacteos,

                'otros' => $otros,

                // TOTALES
                'deducciones' => $totalDeducciones,

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

    public function guardarDeduccion($productorId, $tipo, $monto)
    {
        // Convertir a número
        $monto = (float) $monto;

        // Evitar negativos
        if ($monto < 0) {
            $monto = 0;
        }

        Deduction::updateOrCreate(
            [
                'productor_id' => $productorId,
                'semana_inicio' => $this->inicioSemana,
                'tipo' => $tipo,
            ],

            [
                'localidad_id' => $this->localidadId,
                'monto' => $monto,
            ]
        );

        cache()->forget($this->cacheKey());
    }


    public function render()
    {
        return view('livewire.acopio.acopio');
    }
}
