<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Proveedor') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('provider') }}">Proveedores</a></div>
            <div class="breadcrumb-item">Listado de Proveedores</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="provider" :model="$provider" />
    </div>
</x-app-layout>