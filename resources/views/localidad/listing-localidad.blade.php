<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Listado de Comarcas
        </h2>
    </x-slot>

    <div class="py-4">
        
        <div class="max-w-screen-full mx-auto sm:px-6 lg:px-8">

            <x-localidad.menu-localidad />

            <div class="overflow-x-auto">

                <table class="table table-zebra border border-gray-300">
                    <thead>
                        <tr class="bg-base-400 border-b">
                            <th class="px-6 py-3 uppercase">
                                Editar
                            </th>
                            <th class="px-6 py-3 uppercase">
                                Comarca
                            </th>
                            <th class="px-6 py-3 uppercase hidden md:table-cell">
                                Fecha Creación
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($localidades as $localidad)
                            <tr class="border-b">
                                <td>
                                    <a href="{{ route('localidad.editar', $localidad->id) }}"
                                        class="btn btn-sm bg-sky-800 text-white hover:bg-gray-600">
                                        <i class="fa-solid fa-pencil"></i>
                                        Editar
                                    </a>
                                </td>

                                <td>
                                    {{ $localidad->nombre }}
                                </td>

                                <td class="hidden md:table-cell">
                                    {{ $localidad->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>



    </div>
</x-app-layout>
