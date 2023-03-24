<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Datos Consumo Gas') }}</h3>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('consumo') }}">Consumo Gases</a></div>
                <div class="breadcrumb-item">Modificar  Consumo Gas</div>
            </div>
        </x-slot>

    <div>
        <livewire:gasseconsumo-component action="updateConsumo" :consumoId="request()->consumoId" />
     </div>
</x-app-layout>
