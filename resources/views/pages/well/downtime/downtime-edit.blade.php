<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Parada') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('downtime') }}">Paradas de pozo</a></div>
            <div class="breadcrumb-item">Modificar Parada</div>
        </div>
    </x-slot>

    <div>
        <livewire:well-down-time-create action="updateWellDownTime" :welldowntimeId="request()->welldowntimeId" />
    </div>
</x-app-layout>
