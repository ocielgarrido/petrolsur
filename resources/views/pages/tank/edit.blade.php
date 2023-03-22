<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Editar Tanque') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('tank') }}">Tanques</a></div>
            <div class="breadcrumb-item">Editar Tanque</div>
        </div>
    </x-slot>

    <div>
         {{-- @livewire('tank-create', ['action' => 'updateTank', wire:tan]) --}}
         <livewire:tank-create action="updateTank" :tankId="request()->tankId" />
    </div>
</x-app-layout>
