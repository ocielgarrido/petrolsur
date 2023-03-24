<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Consumo de Gas') }}
        </x-slot>

        <x-slot name="description">
            {{ __('--') }}
        </x-slot>
     
        <x-slot name="form"> 
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="area_id" value="{{ __('Area:') }}" />               
                <select class="form-select" wire:model.defer="gasse.area_id" disabled style="width: 100%">
                    <option value="0">--Seleccione--</option>
                    <option value="1">CCO-NORTE</option>                                      
                </select>
                <x-jet-input-error for="gasse..area_id" class="mt-2" />
            </div>       
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="gasse.fecha" value="{{ __('Fecha:') }}" />
                <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="gasse.fecha" required placeholder="Seleccione fecha">
                <x-jet-input-error for="gasse.fecha" class="mt-2" />        
            </div>  
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="pm10" value="{{ __('Consumo:') }}" />
                <x-jet-input id="pm10" type="number" step="1"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="gasse.pm10" />
                <x-jet-input-error for="gasse.pm10" class="mt-2" />        
            </div>  

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>
            <x-jet-button>            
                    {{ __($button['submit_text']) }}                
               
            </x-jet-button>     
            <button  onclick="window.location.href='/consumo'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
    
         </x-slot>
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        flatpickr(document.getElementsByClassName('flatpickr'),{
          enableTime: false,
          dateFormat: 'd-m-Y',
          locale: "es",
      
        })
      }) 
    </script> 
