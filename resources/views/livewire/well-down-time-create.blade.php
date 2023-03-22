<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
      
        <x-slot name="title">
            {{ __('Parada de Pozo') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Todos los campos son obligatorios') }}
            <p class="text-danger">Importante.</p>
            <p class="text-danger">Para un correcto cálculo, asegúrese de tener cargado un control de pozo.</p>
            <p class="text-danger">si aún no ha cargado un control haga click en siguiente enlace.</p>
            <a href="{{ route('wellcontrol.create') }}">Click acá </a>
        </x-slot>  
           
        <x-slot name="form">
          
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2"> 
                    <x-jet-label for="area_id" value="{{ __('Area:') }}" />               
                     <select id="area_id" class="form-select" wire:model.defer="welldowntime.area_id" style="width: 100%" >
                        <option value="0">--Seleccione--</option>
                        <option value="1">CCO-NORTE</option>                                      
                    </select>
                    <x-jet-input-error for="welldowntime.area_id" class="mt-2" />
                </div>

                <div class="mx-2"> 
                    <x-jet-label for="well" value="{{ __('Pozo') }}" />
                    <select class="form-select" wire:model.defer="welldowntime.well_id"  style="width: 100%">
                    <x-jet-label for="well" value="{{ __('Pozo') }}" />
                        <option value="--">--Seleccione--</option>
                        @foreach($wells as $well)
                        <option value="{{$well->id}}">{{$well->pozo}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="welldowntime.well_id" class="mt-2" /> 
               </div> 
   
            </div>    
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2">           
                    <x-jet-label for="fecha" value="{{ __('Fecha:') }}" />                       
                    <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="welldowntime.fecha" required  placeholder="Seleccione fecha">
                     <x-jet-input-error for="welldowntime.fecha" class="mt-2" />               
                </div>
                <div class="mx-2">           
                    <x-jet-label for="horas" value="{{ __('Horas:') }}" />
                    <x-jet-input id="horas" type="number" step="1"  min="1" max="24" class="mt-1 block w-full form-control shadow-none" wire:model.defer="welldowntime.horas" wire:blur="$emit('getDataControl')" required />
                    <x-jet-input-error for="welldowntime.horas" class="mt-2" />
                </div>            
 
            </div>            
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2"> 
                    <x-jet-label for="well" value="{{ __('Causa parada') }}" />
                    <select class="form-select" wire:model.defer="welldowntime.well_cause_id" style="width: 100%" >
                        <option value="--">--Seleccione--</option>
                        @foreach($wellcauses as $wellcause)
                        <option value="{{$wellcause->id}}">{{$wellcause->causa}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="welldowntime.well_cause_id" class="mt-2" /> 
                </div>
                 <div class="mx-2"> 
                    <x-jet-label for="oil_perdido_mt3" value="{{ __('Petróleo Neto mt3') }}" />
                    <x-jet-input id="oil_perdido_mt3" type="number" step="0.001" class="mt-1 block w-full form-control shadow-none" wire:model.defer="welldowntime.oil_perdido_mt3" disabled required/>
                    <x-jet-input-error for="welldowntime.oil_perdido_mt3" class="mt-2" /> 
                 </div> 
           </div>
           <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2"> 
                    <x-jet-label for="gas_perdido_mt3" value="{{ __('Gas mt3') }}" />
                    <x-jet-input id="gas_perdido_mt3" type="number" step="0.001" class="mt-1 block w-full form-control shadow-none" wire:model.defer="welldowntime.gas_perdido_mt3" disabled required/>
                    <x-jet-input-error for="welldowntime.gas_perdido_mt3" class="mt-2" /> 
                </div> 
               <div class="mx-2"> 
                    <x-jet-label for="agua_perdido_mt3" value="{{ __('Agua mt3') }}" />
                    <x-jet-input id="agua_perdido_mt3" type="number" step="0.001" class="mt-1 block w-full form-control shadow-none" wire:model.defer="welldowntime.agua_perdido_mt3" disabled required/>
                    <x-jet-input-error for="welldowntime.agua_perdido_mt3" class="mt-2" /> 
                </div> 
          </div>            
          <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-1 gap-5">
                <div class="form-group col-span-6 sm:col-span-5">
                    <x-jet-label for="obs" value="{{ __('Observaciones:') }}" />
                    <x-textarea  id="obs" rows="3" cols="30" wire:model.defer="welldowntime.obs" style="width: 100%"/>
                    <x-jet-input-error for="welldowntime.obs" class="mt-2" />        
                </div>  
           </div>
             
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __($button['submit_text']) }}
            </x-jet-button>
            <button  onclick="window.location.href='/welldowntime'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
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
         maxDate: "{!! $welldowntime->fecha->format('d-m-Y') !!}"
     
       })
     })
   
    
   </script>      
   
