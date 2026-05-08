<?php

namespace App\Livewire\Localidad;

use Livewire\Component;
use App\Models\Localidad;
use Illuminate\Validation\Rule;


class EditarLocalidad extends Component
{
    public $localidad;
    public $nombre;
    public $creado;
    public $actualizado;

    public function mount($localidadId)
    {
        $this->localidad = Localidad::findOrFail($localidadId);
        $this->nombre = $this->localidad->nombre;
        $this->creado = $this->localidad->created_at;
        $this->actualizado = $this->localidad->updated_at;
    }

    public function actualizar()
    {
        $this->validate([
            'nombre' => ['required', 'string', Rule::unique('localidads', 'nombre')->ignore($this->localidad->id)],
        ]);

        // Asignamos el nuevo valor
        $this->localidad->nombre = $this->nombre;

        // Verificamos si cambió
        if (!$this->localidad->isDirty('nombre')) {
            session()->flash('info', 'Sin cambios');
            return;
        }

        $this->localidad->save();

        session()->flash('status', 'Localidad actualizada correctamente');
    }

    public function render()
    {
        return view('livewire.localidad.editar-localidad');
    }
}
