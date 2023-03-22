<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Backups') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Listado de Backup Base Datos</div>
        </div>
    </x-slot>

        <div>
            @livewire('backup-component')
        </div>
 
</x-app-layout>

