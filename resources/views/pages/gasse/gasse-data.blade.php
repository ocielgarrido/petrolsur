<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Gasess') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('gasse') }}">Gases</a></div>
            <div class="breadcrumb-item">Listado carga Gas</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="gasse" :model="$gasse" />
    </div>
</x-app-layout>