<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nueva Venta') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('sale') }}">Venta</a></div>
            <div class="breadcrumb-item">Nueva Venta</div>
        </div>
    </x-slot>

    <div>
        <livewire:sale-create action="createSale" />
    </div>
</x-app-layout>
