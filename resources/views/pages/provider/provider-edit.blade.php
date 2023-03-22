<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Proveedor') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('provider') }}">Proveedores</a></div>
            <div class="breadcrumb-item">Modificar Proveedor</div>
        </div>
    </x-slot>

    <div>
        <livewire:provider-create action="updateProvider" :providerId="request()->providerId" />
    </div>
</x-app-layout>
