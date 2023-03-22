<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Areas') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Datos Area</a></div>
            <div class="breadcrumb-item"><a href="#">Listado Area</a></div>
        </div>
    </x-slot>

    <div>
       <h1>En proyecto</h1>
    </div>
</x-app-layout>