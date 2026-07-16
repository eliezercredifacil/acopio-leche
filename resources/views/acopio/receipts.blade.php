<x-app-layout>

    <x-slot name="title">
        Recibos
    </x-slot>

    <x-slot name="favicon">
        {{ asset('images/icons/impresora.png') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            🧾 Recibos
        </h2>
    </x-slot>

    <div class="py-4">

        <div class="max-w-screen-full mx-auto sm:px-6 lg:px-8">            

            <x-acopio.menu-acopio />
            
            <livewire:acopio.recibos />

        </div>

    </div>

</x-app-layout>