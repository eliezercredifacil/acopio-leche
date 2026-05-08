<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Productores
        </h2>
    </x-slot>

    <div class="py-4">

        <div class="max-w-screen-full mx-auto sm:px-6 lg:px-8">            

            <x-productor.menu-productor />

            <livewire:productor.listar-productor />

        </div>

    </div>

</x-app-layout>
