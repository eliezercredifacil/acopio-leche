<x-app-layout>

    <x-slot name="title">
        Resumen Semanal
    </x-slot>

    <x-slot name="favicon">
        {{ asset('images/icons/libro.png') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            📚 Resumen Semanal
        </h2>
    </x-slot>

    <div class="py-4">

        <div class="max-w-screen-full mx-auto sm:px-6 lg:px-8">            

            <x-acopio.menu-acopio />
                    
            <livewire:acopio.resumen-semanal />

        </div>

    </div>

</x-app-layout>