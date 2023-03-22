<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Novedades') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('post') }}">Novedades</a></div>
            <div class="breadcrumb-item">Listado de Novedades</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="post" :model="$post" />
    </div>
</x-app-layout>