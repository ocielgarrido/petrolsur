<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo Control') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('wellintervention') }}">Intervenciones</a></div>
            <div class="breadcrumb-item">Nueva Intervención</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:well-intervention-create action="createWellIntervention" />
    </div>
</x-app-layout>
