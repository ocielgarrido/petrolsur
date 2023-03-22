<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Editar medición') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('oil') }}">Medicion</a></div>
            <div class="breadcrumb-item"><a href="#">Editar Medicion</a></div>
        </div>
    </x-slot>

    <div>
         <livewire:oil-create action="updateOil" :oilId="request()->oilId" />
     
    </div>
</x-app-layout>
