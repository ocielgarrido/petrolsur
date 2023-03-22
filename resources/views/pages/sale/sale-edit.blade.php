<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Venta') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('sale') }}">Venta</a></div>
            <div class="breadcrumb-item">Modificar Venta</div>
        </div>
    </x-slot>

    <div>
        <livewire:sale-create action="updateSale" :saleId="request()->saleId" />
    </div>
</x-app-layout>
