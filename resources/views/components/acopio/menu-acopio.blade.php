<div role="tablist" class="tabs tabs-box mb-3 hidden md:block">
    <a href="{{ route('acopio') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('acopio') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-chart-line px-1"></i>
        Reporte de esta semana
    </a>

    <a href="{{ route('acopio.resumen-semanal') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('acopio.resumen-semanal') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-chart-simple px-1"></i>
        Resumen semanal
    </a>

    <a href="{{ route('acopio') }}" role="tab"
        class="tab border-2 border-solid {{ request()->routeIs('acopio0') ? 'bg-sky-800 font-bold text-white' : '' }}">
        <i class="fa-solid fa-file-invoice-dollar px-1"></i>
        Recibos
    </a>
    
</div>