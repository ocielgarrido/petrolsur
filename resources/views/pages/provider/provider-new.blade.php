<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo Proveedor') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Proveedores</a></div>
            <div class="breadcrumb-item"><a href="{{ route('provider') }}">Nuevo Proveedor</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:provider-create action="createProvider" />
    </div>
</x-app-layout>
