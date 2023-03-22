<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Movimiento') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('movement') }}">Movimientos</a></div>
            <div class="breadcrumb-item">Modificar Movimiento</div>
        </div>
    </x-slot>

    <div>
        <livewire:movement-create action="updateMovement" :userId="request()->movementId" />
    </div>
</x-app-layout>
