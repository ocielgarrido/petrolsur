<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Producción Tanques') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('oil') }}"> Tanques</a></div>
            <div class="breadcrumb-item">Listado producción</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="oil" :model="$oil" />
    </div>
</x-app-layout>