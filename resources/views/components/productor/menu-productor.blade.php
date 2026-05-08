<div role="tablist" class="tabs tabs-box mb-3 hidden md:block">
    <a href="{{ route('productor') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('productor') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-list-ul px-1"></i>
        Listado de Productores
    </a>

    <a href="{{ route('productor.agregar') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('productor.agregar') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-plus px-1 "></i>
        Agregar Productor
    </a>
</div>

<div class="block md:hidden mb-3">

    <ul class="menu menu-horizontal bg-base-200 rounded-box">
        <li>
            <a href="{{ route('productor') }}"
                class="border-2 border-solid {{ request()->routeIs('productor') ? 'bg-sky-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-list px-1"></i>
                Productores
            </a>
        </li>
        <li>
            <a href="{{ route('productor.agregar') }}"
                class="border-2 border-solid {{ request()->routeIs('productor.agregar') ? 'bg-sky-800 font-bold text-white' : '' }}">
                <i class="fa-solid fa-plus px-1 "></i>
                Agregar Productor
            </a>
        </li>
    </ul>

</div>
