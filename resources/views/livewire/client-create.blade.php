<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Clientes') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Comlete todos los campos') }}
        </x-slot>
     
        <x-slot name="form"> 
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="client.nombre" value="{{ __('Razón Social') }}" />
                <x-jet-input id="nombre" type="text" maxlength="30" class="mt-1 block w-full form-control shadow-none" wire:model.defer="client.nombre" />
                <x-jet-input-error for="client.nombre" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="client.cuit" value="{{ __('Cuit (sin puntos ni guiones)') }}" />
                <x-jet-input id="cuit" type="text" maxlength="11" class="mt-1 block w-full form-control shadow-none" wire:model.defer="client.cuit" />
                <x-jet-input-error for="client.cuit" class="mt-2" />
            </div>          
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="client.correo" value="{{ __('Correo:') }}" />               
                <x-jet-input id="correo" type="email" maxlength="50" class="mt-1 block w-full form-control shadow-none" wire:model.defer="client.email" />
                <x-jet-input-error for="client.correo" class="mt-2" />
           </div>
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="client.telefono" value="{{ __('Telefóno') }}" />
                <x-jet-input id="telefono" type="text" maxlength="20" class="mt-1 block w-full form-control shadow-none" wire:model.defer="client.telefono" />
                <x-jet-input-error for="client.telefono" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="client.direccion" value="{{ __('Dirección') }}" />
                <x-jet-input id="direccion" type="text" maxlength="50" class="mt-1 block w-full form-control shadow-none" wire:model.defer="client.direccion" />
                <x-jet-input-error for="client.direccion" class="mt-2" />
            </div> 
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>
            <x-jet-button>
                {{ __($button['submit_text']) }}
                <button  onclick="window.location.href='/client'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>

            </x-jet-button>            
        </x-slot>
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
