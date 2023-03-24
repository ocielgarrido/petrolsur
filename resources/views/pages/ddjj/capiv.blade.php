<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nueva Parada') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('downtime') }}">Paradas Compresor</a></div>
            <div class="breadcrumb-item">Nuevo Parada Compresor</div>
        </div>
    </x-slot>

    <div>
        <livewire:ddjj-component />
    </div>
</x-app-layout>