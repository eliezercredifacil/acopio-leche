<?php

namespace App\Livewire\Acopio;

use Livewire\Component;

class ResumenSemanal extends Component
{
    public $fechaReporte;


    public function render()
    {
        return view('livewire.acopio.resumen-semanal');
    }
}
