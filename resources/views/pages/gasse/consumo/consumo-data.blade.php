<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Consumo  de Gas') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('consumo') }}">Consumo Gases</a></div>
            <div class="breadcrumb-item">Listado Consumo Gas</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="consumo" :model="$consumos" />
    </div>
</x-app-layout>