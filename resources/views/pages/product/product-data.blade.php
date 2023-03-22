<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Productos') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('product') }}">Productos</a></div>
            <div class="breadcrumb-item">Listado de Productos</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="product" :model="$product" />
    </div>
</x-app-layout>