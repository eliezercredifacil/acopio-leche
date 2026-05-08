<?php

namespace App\Livewire\Localidad;

use Livewire\Component;
use App\Models\Localidad;
use Illuminate\Validation\Rule;

class AgregarLocalidad extends Component
{
    public $nombre;

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', Rule::unique('localidads', 'nombre')]
        ];
    }

    public function agregar()
    {
        $this->nombre = trim($this->nombre);
        $this->validate();
        $localidad = new Localidad();
        $localidad->nombre = $this->nombre;
        $localidad->save();

        session()->flash('status', 'Localidad creada correctamente');

        // Limpiar el campo después de guardar
        $this->reset('nombre');
    }

    public function render()
    {
        return view('livewire.localidad.agregar-localidad');
    }
}
