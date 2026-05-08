<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Editar Productor
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-screen-full mx-auto px-4 sm:px-6 lg:px-8">

            <div class="breadcrumbs text-sm border-b">
                <ul>
                    <li>
                        <a href="{{ route('productor') }}" class="btn btn-sm bg-sky-800 text-white" wire:navigate>
                            <i class="fa-solid fa-arrow-left"></i>
                            Regresar
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-person"></i>
                            {{ $productor->nombre }}
                        </a>
                    </li>
                </ul>
            </div>

            <livewire:productor.editar-productor :productorId="$productor->id" />

        </div>

    </div>

</x-app-layout>
