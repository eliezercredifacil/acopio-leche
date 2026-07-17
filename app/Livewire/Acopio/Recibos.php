<?php

namespace App\Livewire\Acopio;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Productor;
use App\Models\Localidad;
use Carbon\Carbon;


class Recibos extends Component
{
    use WithPagination;

    public $fechaReporte;

    public $tipoSemana = 'A';

    public $localidadId;

    public $inicioSemana;

    public $finSemana;

    public $fechas = [];

    public $localidades;

    public $buscarProductor = '';

    protected $queryString = ['localidadId', 'tipoSemana', 'fechaReporte'];

    public function mount()
    {
        $this->localidades = Localidad::orderBy('nombre')->get();

        // Primera localidad por defecto
        $this->localidadId ??= $this->localidades->first()?->id;

        $this->fechaReporte ??= now()->toDateString();

        $this->calcularSemana();
    }

    public function updatedLocalidadId()
    {
        $this->resetPage();

        $this->calcularSemana();
    }

    public function updatedTipoSemana()
    {
        $this->resetPage();

        $this->calcularSemana();
    }

    public function updatedFechaReporte()
    {
        $this->resetPage();

        $this->calcularSemana();
    }

    public function updatedBuscarProductor()
    {
        $this->resetPage();
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

    public function render()
    {
        if (trim($this->buscarProductor) !== '') {

            $productores = Productor::search($this->buscarProductor)

                ->query(function ($query) {

                    $query->with([

                        'localidad',

                        'acopios' => function ($q) {

                            $q->whereBetween('fecha', [
                                $this->inicioSemana,
                                $this->finSemana
                            ])
                                ->where('tipo_semana', $this->tipoSemana)
                                ->orderBy('fecha');
                        },

                        'deductions' => function ($q) {

                            $q->where('semana_inicio', $this->inicioSemana);
                        }

                    ])
                        ->where('activo', true)
                        ->where('localidad_id', $this->localidadId)
                        ->where('semana', $this->tipoSemana);
                })
                ->paginate(12);
        } else {

            $productores = Productor::with([

                'localidad',

                'acopios' => function ($q) {

                    $q->whereBetween('fecha', [
                        $this->inicioSemana,
                        $this->finSemana
                    ])
                        ->where('tipo_semana', $this->tipoSemana)
                        ->orderBy('fecha');
                },

                'deductions' => function ($q) {

                    $q->where('semana_inicio', $this->inicioSemana);
                }

            ])

                ->where('activo', true)
                ->where('localidad_id', $this->localidadId)
                ->where('semana', $this->tipoSemana)
                ->orderBy('nombre')
                ->paginate(12);
        }

        return view('livewire.acopio.recibos', compact('productores'));
    }


}
