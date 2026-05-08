<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Editar comarca
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-screen-full mx-auto px-4 sm:px-6 lg:px-8">

            <div class="breadcrumbs text-sm border-b">
                <ul>
                    <li>
                        <a href="{{ route('localidad') }}" class="btn btn-sm bg-sky-800 text-white">
                            <i class="fa-solid fa-arrow-left"></i>
                            Regresar
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-location-dot"></i>
                            Comarca {{ $localidad->nombre }}
                        </a>
                    </li>
                </ul>
            </div>
            
            <livewire:localidad.editar-localidad :localidadId="$localidad->id" />

        </div>

    </div>
</x-app-layout>
