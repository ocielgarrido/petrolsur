<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nueva Medición') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('oil') }}">Tanques</a></div>
            <div class="breadcrumb-item">Nueva medición</div>
        </div>
    </x-slot>

    <div>
        @livewire('oil-create', ['action' => 'createOil'])
    </div>
</x-app-layout>
