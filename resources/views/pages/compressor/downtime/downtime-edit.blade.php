<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Parada') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('downtime') }}">Paradas Compresor</a></div>
            <div class="breadcrumb-item">Modificar Parada Compresor</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:compressor-down-time-create action="updateCompressorDownTime" :compressordowntimeId="request()->compressordowntimeId" />
  
    </div>
</x-app-layout>
