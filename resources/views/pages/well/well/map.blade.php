<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Ubicación Pozo') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pozos</a></div>
            <div class="breadcrumb-item"><a href="{{ route('well') }}">Ubicación</a></div>
        </div>
    </x-slot>

    <div>
        // Leaflet 
        // Mapa básico
        <x-maps-leaflet></x-maps-leaflet> 
        // Mapa con Latitud y Longitud
        <x-maps-leaflet :centerPoint="['lat' => 52.16, 'long' => 5]"></x-maps-leaflet> 
        // Mapa con Zoom 
        <x-maps-leaflet :zoomLevel="6"></x-maps-leaflet> 
        // Agregarle Marcadores
        <x-maps-leaflet :markers="[['lat' => 52.16444513293423, 'long' => 5.985622388024091]]"></x-maps-leaflet>
    </div>
</x-app-layout>