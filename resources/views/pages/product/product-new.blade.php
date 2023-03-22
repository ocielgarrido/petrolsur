<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo Producto') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('product') }}">Productos</a></div>
            <div class="breadcrumb-item">Nuevo Producto</div>
        </div>
    </x-slot>

    <div>
        <livewire:product-create action="createProduct" />
    </div>
</x-app-layout>
