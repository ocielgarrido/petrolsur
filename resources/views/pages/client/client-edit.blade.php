<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Cliente') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('client') }}">Cliente</a></div>
            <div class="breadcrumb-item">Modificar Cliente</div>
        </div>
    </x-slot>

    <div>
        <livewire:client-create action="updateClient" :clientId="request()->clientId" />
    </div>
</x-app-layout>
