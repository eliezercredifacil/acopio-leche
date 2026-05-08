<?php

namespace App\Livewire\Productor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Productor;

class ListarProductor extends Component
{
    use WithPagination;

    public $search = '';
    public $ultimoId;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (trim($this->search) !== '') {
            $productores = Productor::search($this->search)
                ->query(fn($query) => $query->with('localidad'))
                ->paginate(5);
        } else {
            $productores = Productor::with('localidad')
                ->latest()
                ->paginate(5);
        }

        return view('livewire.productor.listar-productor', [
            'productores' => $productores
        ]);
    }
}
