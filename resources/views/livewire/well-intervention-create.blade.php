<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Intervenciones') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete todos los campos') }}
        </x-slot>
     
        <x-slot name="form"> 
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="area_id" value="{{ __('Area:') }}" />               
                <select class="form-select" wire:model.defer="wellintervention.area_id" style="width: 100%" >
                    <option value="0">--Seleccione--</option>
                    <option value="1">CCO-NORTE</option>                                      
                </select>
                <x-jet-input-error for="..area_id" class="mt-2" />
            </div> 

            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="Pozo" value="{{ __('Pozo') }}" />
                <select id="Pozo" class="form-select" wire:model.defer="wellintervention.well_id" required style="width: 100%">
                    <option value="--">--Seleccione--</option>
                    @foreach($wells as $well)
                    <option value="{{$well->id}}">{{$well->pozo}}</option>   
                    @endforeach                                   
                </select>
                <x-jet-input-error for="wellintervention.well_id" class="mt-2" />                    
            </div>   

            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="fecha" value="{{ __('Fecha:') }}" />
                <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="wellintervention.fecha" required placeholder="Seleccione fecha">               <x-jet-input-error for="post.fecha" class="mt-2" />        
                <x-jet-input-error for="wellintervention.fecha" class="mt-2" />        
            </div>  
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="motivo" value="{{ __('Motivo:') }}" />
                <x-textarea  id="motivo" rows="3" cols="30" wire:model.defer="wellintervention.motivo" style="width: 100%"/>
                <x-jet-input-error for="wellintervention.motivo" class="mt-2" />        
            </div>  
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="obs" value="{{ __('Observaciones:') }}" />
                <x-textarea  id="obs" rows="3" cols="30" wire:model.defer="wellintervention.obs" style="width: 100%"/>
                <x-jet-input-error for="wellintervention.obs" class="mt-2" />        
            </div>  
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>
            <x-jet-button>
                {{ __($button['submit_text']) }}
                <button  onclick="window.location.href='/wellintervention'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
 
            </x-jet-button>            
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
          minDate: "{!! $primerDia !!}",
          maxDate: "{!! $wellintervention->fecha->format('d-m-Y') !!}"
      
        })
      })

 </script>  
