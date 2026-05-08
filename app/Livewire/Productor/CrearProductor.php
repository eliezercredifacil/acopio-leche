<?php

namespace App\Livewire\Productor;

use Livewire\Component;

use App\Models\Localidad;
use App\Models\Productor;

class CrearProductor extends Component
{
    public $nombre;
    public $cedula;
    public $telefono;
    public $semana;
    public $localidad_id;
    public $direccion;
    public $localidades = [];
    public $ultimoId = null;

    public function mount()
    {
        $this->localidades = Localidad::orderBy('nombre', 'asc')->get();
    }

    protected $rules = [
        'nombre' => 'required|string|min:5',
        'cedula' => 'required|unique:productors,cedula',
        'telefono' => 'required|numeric|min:8',
        'localidad_id' => 'required',
        'direccion' => 'required|string|min:5',
        'semana' => 'required'
    ];

    public function AgregarProductor()
    {
        $this->validate();

        $productor = new Productor();
        $productor->localidad_id = $this->localidad_id;
        $productor->nombre = $this->nombre;
        $productor->cedula = $this->cedula;
        $productor->telefono = $this->telefono;
        $productor->direccion = $this->direccion;
        $productor->semana = $this->semana;
        $productor->save();
        
        session()->flash('status', 'Productor creado correctamente.');
        return redirect()->to('/productor?ultimoId=' . $productor->id);
    }

    public function render()
    {
        return view('livewire.productor.crear-productor');
    }
}
