<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Permisos') }}
        </x-slot>

        <x-slot name="description">
            {{ __('--') }}
        </x-slot>
     
        <x-slot name="form"> 
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="name" value="{{ __('A 9300:') }}" />
                <x-jet-input id="name" type="text"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="permission.name"  />
                <x-jet-input-error for="permission.name" class="mt-2" />        
            </div>  
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>
            <x-jet-button>
                {{ __($button['submit_text']) }}
                <button  onclick="window.location.href='/permission'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
 
            </x-jet-button>            
        </x-slot>
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
