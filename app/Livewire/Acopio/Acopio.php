<?php

namespace App\Livewire\Acopio;

use Carbon\Carbon;

use Livewire\Component;
use App\Models\Localidad;
use App\Models\Productor;

class Acopio extends Component
{
    public $fechas = [];
    public $localidades;
    public $localidadId;
    public $localidad;

    protected $queryString = ['localidadId'];

    public function mount()
    {
        $this->localidades = Localidad::orderBy('nombre')->get();

        // Si no viene en URL, usar la primera localidad
        $this->localidadId ??= $this->localidades->first()?->id;
        $this->localidad = Localidad::find($this->localidadId)?->nombre;


        $inicioSemana = Carbon::now()->startOfWeek(); // lunes por defecto

        for ($i = 0; $i < 7; $i++) {
            $this->fechas[] = $inicioSemana->copy()->addDays($i);
        }
    }

    public function getProductoresProperty()
    {
        return cache()->remember(
            'productores_' . $this->localidadId,
            5, // segundos
            fn() => Productor::with(['acopios' => function ($q) {
                $q->whereBetween('fecha', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            }])
                ->where('activo', true)
                ->where('localidad_id', $this->localidadId)
                ->orderBy('nombre')
                ->get()
        );
    }

    public function render()
    {
        return view('livewire.acopio.acopio');
    }
}
