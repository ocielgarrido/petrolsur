<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Indrementos/Mermas') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('variation') }}">Incrementos/Mermas</a></div>
            <div class="breadcrumb-item">Incrementos / Mermas/</div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="wellvariation" :model="$wellvariation" />
   
    </div>
</x-app-layout>
