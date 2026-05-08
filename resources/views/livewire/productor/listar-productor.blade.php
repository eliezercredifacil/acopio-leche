<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <x-productor.alerts type="success" :message="session('status')" />

    <div class="mb-3 relative max-w-sm">

        <input type="text" class="input bg-base-100 w-full pr-10" wire:model.live.debounce.300ms="search" name="search"
            placeholder="Buscar productor" />

        @if ($search)
            <button wire:click="$set('search', '')"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                ✕
            </button>
        @endif

    </div>

    <div wire:loading wire:target="search" class="text-sm text-gray-500 mb-2">
        <span class="loading loading-spinner loading-md"></span>
        Buscando...
    </div>

    <div class="overflow-x-auto">

        <table class="table border border-gray-300 table-zebra">
            <thead class="border-b">
                <tr>
                    <th class="px-6 py-3 uppercase">Editar</th>
                    <th class="px-6 py-3 uppercase">Nombre</th>
                    <th class="px-6 py-3 uppercase">Semana</th>
                    <th class="px-6 py-3 uppercase hidden md:table-cell">Teléfono</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productores as $productor)
                    <tr x-data="{ show: {{ $productor->id == $this->ultimoId ? 'true' : 'false' }} }" x-init="if (show) setTimeout(() => show = false, 3000)"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" :class="show ? 'bg-green-200 dark:bg-green-800' : ''"
                        class="border-b hover:bg-base-300 transition-all duration-500">

                        <td>
                            <a href="{{ route('productor.editar', $productor->id) }}"
                                class="btn btn-sm bg-sky-800 text-white hover:bg-gray-600" wire:navigate>
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>
                        </td>

                        <td>
                            <div class="flex items-center gap-3">

                                <div>
                                    <div class="font-bold">
                                        {{ $productor->nombre }}
                                    </div>
                                    <div class="text-sm opacity-50">{{ $productor->localidad->nombre }}</div>
                                </div>

                            </div>
                        </td>

                        <td>
                            {{ $productor->semana == 'A' ? 'Domingo a Sábado' : 'Viernes a Jueves' }}
                        </td>

                        <td class="hidden md:table-cell">
                            <span class="badge badge-ghost badge-sm">{{ $productor->telefono }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="mt-4 max-w-3xl">
        {{ $productores->links() }}
    </div>

</div>
