<?php

namespace App\Livewire\Productor;

use Livewire\Component;
use App\Models\Localidad;
use App\Models\Productor;
use Illuminate\Validation\Rule;

class EditarProductor extends Component
{
    public $productorId;
    public $nombre;
    public $cedula;
    public $telefono;
    public $localidad_id;
    public $semana;
    public $direccion;
    public $localidades;
    public $productor;

    public function mount($productorId)
    {
        $this->localidades = Localidad::orderBy('nombre', 'asc')->get();
        $this->productor = Productor::findOrFail($productorId);
        $this->nombre = $this->productor->nombre;
        $this->cedula = $this->productor->cedula;
        $this->telefono = $this->productor->telefono;
        $this->localidad_id = $this->productor->localidad_id;
        $this->semana = $this->productor->semana;
        $this->direccion = $this->productor->direccion;
    }

    public function EditarProductorSuccess()
    {
        $this->validate([
            'nombre' => ['required', 'string'],
            'cedula' => ['required', 'string', Rule::unique('productors', 'cedula')->ignore($this->productor->id)],
            'telefono' => ['required', 'string'],
            'localidad_id' => ['required'],
            'semana' => ['required'],
            'direccion' => ['required'],
        ]);

        // 🔹 Asignar valores manualmente
        $this->productor->nombre = $this->nombre;
        $this->productor->cedula = $this->cedula;
        $this->productor->telefono = $this->telefono;
        $this->productor->localidad_id = $this->localidad_id;
        $this->productor->semana = $this->semana;
        $this->productor->direccion = $this->direccion;

        // 🔹 Verificar ANTES de guardar
        if (!$this->productor->isDirty()) {
            session()->flash('info', 'Sin cambios');
            return;
        }

        // Guardar
        $this->productor->save();
        session()->flash('status', 'Productor actualizado correctamente');
    }

    public function render()
    {
        return view('livewire.productor.editar-productor');
    }
}
