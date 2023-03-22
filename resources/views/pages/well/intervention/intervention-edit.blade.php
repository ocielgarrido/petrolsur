<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Producto') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('wellintervention') }}">Intervenciones</a></div>
            <div class="breadcrumb-item">Modificar Intervención</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:well-intervention-create action="updateWellIntervention" :wellinterventionId="request()->wellinterventionId" />
    </div>
</x-app-layout>
