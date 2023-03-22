<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Intervenciones a Pozo') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('wellintervention') }}">Intervenciones a pozo</a></div>
            <div class="breadcrumb-item">Listado de Intervenciones a pozo</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="wellintervention" :model="$wellintervention" />
    </div>
</x-app-layout>