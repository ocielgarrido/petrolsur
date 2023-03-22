<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Controles a pozo') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('wellcontrol') }}"></a></div>
            <div class="breadcrumb-item">Listado de Controles a pozo</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="wellcontrol" :model="$wellcontrol" />
    </div>
</x-app-layout>