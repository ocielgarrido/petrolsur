<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo Pozo') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pozos</a></div>
            <div class="breadcrumb-item"><a href="{{ route('well') }}">Modificar Pozo</a></div>
        </div>
    </x-slot>

    <div>
        @livewire('well-create', ['action' => 'createWell'])
    </div>
</x-app-layout>
