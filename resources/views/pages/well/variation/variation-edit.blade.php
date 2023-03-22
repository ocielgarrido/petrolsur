<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Producto') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('variation') }}">Incrementos/Mermas</a></div>
            <div class="breadcrumb-item">Modificar Incremento/Merma</div>
        </div>
    </x-slot>

    <div>
        <livewire:well-variation-create action="updateWellVariation" :wellvariationId="request()->wellvariationId" />
    </div>
</x-app-layout>
