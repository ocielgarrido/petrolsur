<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Paradas') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('downtime') }}">Paradas de Compresor</a></div>
            <div class="breadcrumb-item">Listado de Paradas de Compresor</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="compressordowntime" :model="$compressordowntime" />
    </div>
</x-app-layout>