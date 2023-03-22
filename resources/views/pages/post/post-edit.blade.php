<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Modificar Novedad') }}</h3>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('post') }}">Novedades</a></div>
            <div class="breadcrumb-item">Modificar Novedad</div>
        </div>
    </x-slot>

    <div>
        <livewire:post-create action="updatePost" :postId="request()->postId" />
    </div>
</x-app-layout>
