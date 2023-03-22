<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Detalle Producción Tanques' ) }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('oil') }}"> Tanques</a></div>
            <div class="breadcrumb-item">Listado Mediciones</div>
        </div>
    </x-slot>

    <div>
        {{-- @livewire('oil-detail-create')      --}}
        <livewire:oil-detail-create action="update" :oilID="request()->oilId" />

    </div>
</x-app-layout>