<x-app-layout>
    <x-slot name="header_content">
        <h3>{{ __('Pagina no encontrada') }}</h3>       
    </x-slot>

    <div class="container mt-3">
        <div class="row p-3 bg-white containerMsg">
            <div class="col-12 mt-3 text-center">
                <h1 class="MensajeError">Error 404</h1>
                <p>La pagina que estas buscando no existe</p>
                <a href="/dashboard">Volver a inicio</a>
            </div>
        </div>
</div>
</x-app-layout>