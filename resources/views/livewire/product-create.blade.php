<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Productos') }}
        </x-slot>

        <x-slot name="description">
            {{ __('--') }}
        </x-slot>
     
        <x-slot name="form"> 
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="product.nombre" value="{{ __('Nombre producto') }}" />
                <x-jet-input id="nombre" type="text" maxlength="30" class="mt-1 block w-full form-control shadow-none" wire:model.defer="product.nombre" />
                <x-jet-input-error for="product.nombre" class="mt-2" />
            </div>
             <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="api" value="{{ __('Afecta producción:') }}" />               
                <select class="form-select" wire:model.defer="product.production">
                    <option value="0">--Seleccione--</option>
                    <option value="Sí">Sí</option>                                      
                    <option value="No">No</option>                                      
                </select>
                <x-jet-input-error for="product.production" class="mt-2" />   
            </div> 
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>
            <x-jet-button>
                {{ __($button['submit_text']) }}
                <button  onclick="window.location.href='/product'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
 
            </x-jet-button>            
        </x-slot>
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
