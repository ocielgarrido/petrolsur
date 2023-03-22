<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo Cliente') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('client') }}">Clientes</a></div>
            <div class="breadcrumb-item">Nuevo Cliente</div>
        </div>
    </x-slot>

    <div>
        <livewire:client-create action="createClient" />
    </div>
</x-app-layout>
