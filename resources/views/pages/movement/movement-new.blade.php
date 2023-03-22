<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo movimiento') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('movement') }}">Movimientos</a></div>
            <div class="breadcrumb-item">Nuevo Movimiento</div>
        </div>
    </x-slot>

    <div>
        <livewire:movement-create action="createMovement" />
    </div>
</x-app-layout>
