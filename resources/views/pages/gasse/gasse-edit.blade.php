<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Datos Gass') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('gasse') }}">Gases</a></div>
            <div class="breadcrumb-item">Modificar datos Gas</div>
        </div>
    </x-slot>

    <div>
        <livewire:gasse-create action="updateGasse" :gasseId="request()->gasseId" />
    </div>
</x-app-layout>
