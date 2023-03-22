<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo Control') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('tankcontrol') }}">Controles</a></div>
            <div class="breadcrumb-item">Nuevo Control</div>
        </div>
    </x-slot>

    <div>
        <livewire:tank-control-create action="createTankControl" />
    </div>
</x-app-layout>
