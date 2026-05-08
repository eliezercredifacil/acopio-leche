<div role="tablist" class="tabs tabs-box mb-3 hidden md:block">
    <a href="{{ route('localidad') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('localidad') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-table-list px-1"></i>
        Listado de Comarcas
    </a>

    <a href="{{ route('localidad.agregar') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('localidad.agregar') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-plus px-1 "></i>
        Agregar Comarca
    </a>
</div>

<div class="block md:hidden mb-3">

    <ul class="menu menu-horizontal bg-base-200 rounded-box">
        <li>
            <a href="{{ route('localidad') }}"
                class="border-2 border-solid {{ request()->routeIs('localidad') ? 'bg-sky-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-table-list px-1"></i>
                Comarcas
            </a>
        </li>
        <li>
            <a href="{{ route('localidad.agregar') }}"
                class="border-2 border-solid {{ request()->routeIs('localidad.agregar') ? 'bg-sky-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-location-dot px-1"></i>
                Agregar Comarca
            </a>
        </li>
    </ul>

</div>
