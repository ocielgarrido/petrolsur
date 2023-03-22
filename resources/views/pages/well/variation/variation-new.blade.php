<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Nuevo Control') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('variation') }}">Incrementos/Mermas</a></div>
            <div class="breadcrumb-item">Nuevo Incremento / Merma</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:well-variation-create action="createWellVariation" />
    </div>
</x-app-layout>
