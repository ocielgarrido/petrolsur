<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Listado Pozos') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pozos</a></div>
            <div class="breadcrumb-item"><a href="{{ route('well') }}">Listado pozos</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="well" :model="$well" />
    </div>
</x-app-layout>
