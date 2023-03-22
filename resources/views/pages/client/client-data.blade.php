<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Clientes') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('client') }}">Clientes</a></div>
            <div class="breadcrumb-item">Listado de Clientes</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="client" :model="$client" />
    </div>
</x-app-layout>