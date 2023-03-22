<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">      
        <x-slot name="title">
            {{ __('Controles a Tanques') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Todos los campos son obligatorios') }}
            <p class="text-danger">Importante.</p>
            <p class="text-danger">Para un correcto cálculo, asegúrese de cargar los datos correctamente.</p>
        </x-slot>  
            
        <x-slot name="form">          
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2"> 
                     <x-jet-label for="area_id" value="{{ __('Area:') }}" />               
                     <select id="area_id" class="form-select" wire:model.defer="tankcontrol.area_id" style="width: 100%" >
                        <option value="0">--Seleccione--</option>
                        <option value="1">CCO-NORTE</option>                                      
                    </select>
                    <x-jet-input-error for="tankcontrol.area_id" class="mt-2" />
                </div>
                <div class="mx-2"> 
                    <x-jet-label for="well" value="{{ __('Tanque') }}" />
                    <select id="tank_id" class="form-select" wire:model.defer="tankcontrol.tank_id" required style="width: 100%">
                        <option value="--">--Seleccione--</option>
                        @foreach($tanks as $tank)
                        <option value="{{$tank->id}}">{{$tank->nombre}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="tankcontrol.tank_id" class="mt-2" />                    
               </div>   
    
            </div>    
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2">           
                    <x-jet-label for="fecha" value="{{ __('Fecha:') }}" />                       
                    <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="tankcontrol.fecha" required   placeholder="Seleccione fecha">
                    <x-jet-input-error for="tankcontrol.fecha" class="mt-2" />               
                </div>
  
                <div class="mx-2">           
                    <x-jet-label for="horas" value="{{ __('%Agua:') }}" />
                    <x-jet-input id="horas" type="number" step="0.1"  min="0" max="100" class="mt-1 block w-full form-control shadow-none"  wire:model.defer="tankcontrol.agua" required />
                    <x-jet-input-error for="tankcontrol.agua" class="mt-2" />
                </div>
           </div> 
           <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="sales" value="{{ __('Sales') }}" />
                        <x-jet-input id="sales" type="number" step="1" min="1" max="50000"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="tankcontrol.sales" required />
                        <x-jet-input-error for="tankcontrol.sales" class="mt-2" /> 
                </div> 

                 <div class="mx-2"> 
                    <x-jet-label for="temp" value="{{ __('Temperatura') }}" />
                    <x-jet-input id="temp" type="number" step="1" max="99" class="mt-1 block w-full form-control shadow-none" wire:model.defer="tankcontrol.temp" required/>
                    <x-jet-input-error for="tankcontrol.temp" class="mt-2" /> 
                </div>
 
            </div> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="densidad" value="{{ __('Densidad') }}" />
                    <x-jet-input id="densidad" type="number" step="0.001" min="0.500" max="1.500"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="tankcontrol.densidad"  required />
                    <x-jet-input-error for="tankcontrol.densidad" class="mt-2" /> 
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
            <button  onclick="window.location.href='/tankcontrol'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
        </x-slot>
     
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>

<script>
    //   $wellcontrol->fecha
   document.addEventListener('DOMContentLoaded', function(){
       flatpickr(document.getElementsByClassName('flatpickr'),{
         enableTime: false,
         dateFormat: 'd-m-Y',
         locale: "es",
         minDate: "{!! $primerDia !!}",
         maxDate: "{!! $tankcontrol->fecha->format('d-m-Y') !!}"
     
       })
     })
   
    
   </script>   
