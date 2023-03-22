<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Control') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('tankcontrol') }}">Controles</a></div>
            <div class="breadcrumb-item">Modificar Control</div>
        </div>
    </x-slot>

    <div>
        <livewire:tank-control-create action="updateTankControl" :tankcontrolId="request()->tankcontrolId" />
    </div>
</x-app-layout>
