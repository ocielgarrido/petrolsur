<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nueva Consumo Gas') }}</h3>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('consumo') }}">Consumo Gases</a></div>
                <div class="breadcrumb-item">Nuevo Consumo Gas</div>
            </div>
        </x-slot>

    <div>
        <livewire:gasseconsumo-component action="createConsumo" />
    </div>
</x-app-layout>
