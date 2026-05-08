<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Agregar Comarca
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-screen-full mx-auto px-4 sm:px-6 lg:px-8">

            <x-localidad.menu-localidad />
            
            <livewire:localidad.agregar-localidad />

        </div>

    </div>
</x-app-layout>
