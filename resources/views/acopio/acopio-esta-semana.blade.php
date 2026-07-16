<x-app-layout>

    <x-slot name="title">
        Acopios
    </x-slot>

    <x-slot name="favicon">
        {{ asset('images/icons/notas.png') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            🐄 Acopios
        </h2>
    </x-slot>


    <div class="py-4">

        <div class="max-w-screen-full mx-auto sm:px-6 lg:px-8">

            <x-acopio.menu-acopio />

            <livewire:acopio.acopio />

        </div>

    </div>

</x-app-layout>