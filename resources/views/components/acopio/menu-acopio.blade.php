<div role="tablist" class="tabs tabs-box mb-3 hidden md:block">

    <a href="{{ route('acopio') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('acopio') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-chart-line"></i>
        Reporte de esta semana
    </a>

    <a href="{{ route('acopio.resumen-semanal') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('acopio.resumen-semanal') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-chart-simple"></i>
        Resumen semanal
    </a>

    <a href="{{ route('acopio.recibos') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('acopio.recibos') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-file-invoice-dollar"></i>
        Recibos
    </a>

</div>

<div class="block md:hidden mb-3">

    <ul class="menu menu-horizontal bg-base-200 rounded-box">
        <li>
            <a href="{{ route('acopio') }}" role="tab"
                class="tab border-2 border-solid {{ request()->routeIs('acopio') ? 'bg-sky-800 font-bold text-white' : '' }}">                
                Reporte
            </a>
        </li>

        <li>
            <a href="{{ route('acopio.resumen-semanal') }}" role="tab"
                class="tab border-2 border-solid {{ request()->routeIs('acopio.resumen-semanal') ? 'bg-sky-800 font-bold text-white' : '' }}">                
                Resumen
            </a>
        </li>

        <li>
            <a href="{{ route('acopio.recibos') }}" role="tab"
                class="tab border-2 border-solid {{ request()->routeIs('acopio.recibos') ? 'bg-sky-800 font-bold text-white' : '' }}">                
                Recibos
            </a>
        </li>

    </ul>

</div>
