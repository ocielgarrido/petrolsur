<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nueva Parada') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('downtime') }}">Paradas de pozo</a></div>
            <div class="breadcrumb-item">Nueva Parada</div>
        </div>
    </x-slot>

    <div>
        <livewire:well-down-time-create action="createWellDownTime" />
    </div>
</x-app-layout>
