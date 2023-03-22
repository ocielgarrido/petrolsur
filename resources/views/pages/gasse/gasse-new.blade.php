<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nueva carga Gas') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('gasse') }}">Gases</a></div>
            <div class="breadcrumb-item">Nueva carga Gas</div>
        </div>
    </x-slot>

    <div>
        <livewire:gasse-create action="createGasse" />
    </div>
</x-app-layout>
