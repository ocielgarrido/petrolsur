<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Controles a Tanques') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('tankcontrol') }}"></a></div>
            <div class="breadcrumb-item">Listado de Controles a Tanques</a></div>
        </div>
    </x-slot>

     <div>
        <livewire:table.main name="tankcontrol" :model="$tankcontrol" />      
    </div>
</x-app-layout>