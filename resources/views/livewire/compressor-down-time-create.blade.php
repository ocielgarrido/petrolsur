<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
      
        <x-slot name="title">
            {{ __('Down time') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete todos los campos') }}
        </x-slot>  
           
        <x-slot name="form">
          
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
               <div class="mx-2"> 
                    <x-jet-label for="well" value="{{ __('Compresor') }}" />
                    <select class="form-select" wire:model.defer="compressordowntime.compressor_id" style="width: 100%">
                        <option value="--">--Seleccione--</option>
                        @foreach($compressor as $compressor)
                        <option value="{{$compressor->id}}">{{$compressor->nombre}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="compressordowntime.compressor_id" class="mt-2" /> 
               </div> 
               <div class="mx-2">           
                    <x-jet-label for="fecha" value="{{ __('Fecha:') }}" />                       
                    <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="compressordowntime.fecha" required placeholder="Seleccione fecha">
                    <x-jet-input-error for="compressordowntime.fecha" class="mt-2" />               
                </div>
   
            </div>    
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2">           
                    <x-jet-label for="horas" value="{{ __('Horas paro:') }}" />
                    <x-jet-input id="horas" type="number" step="0.25"  min="0.25" max="24" class="mt-1 block w-full form-control shadow-none" wire:model.defer="compressordowntime.horas" required />
                    <x-jet-input-error for="compressordowntime.horas" class="mt-2" />
                </div>
                <div class="mx-2"> 
                    <x-jet-label for="horas_paro_msa" value="{{ __('Volumen Perdido mt3') }}" />
                    <x-jet-input id="horas_paro_msa" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="compressordowntime.horas_paro_msa" required/>
                    <x-jet-input-error for="compressordowntime.horas_paro_msa" class="mt-2" /> 
               </div> 
 
            </div>            
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                 <div class="mx-2"> 
                    <x-jet-label for="compressor_causes_id" value="{{ __('Causa / Motivo') }}" />
                    <select class="form-select" wire:model.defer="compressordowntime.compressor_causes_id" style="width: 100%" >                                                                                     
                        <option value="--">--Seleccione--</option>
                        @foreach($compressorcauses as $compressorcause)
                        <option value="{{$compressorcause->id}}">{{$compressorcause->causa}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="compressordowntime.compressor_causes_id" class="mt-2" />                                                                                        
               </div> 
 
            </div>
           <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-1 gap-5">
                <div class="mx-2"> 
                    <x-jet-label for="obs" value="{{ __('Observaciones') }}" />
                    <x-textarea  id="obs" rows="3" cols="30" wire:model.defer="compressordowntime.obs" style="width: 100%"/>
                    <x-jet-input-error for="compressordowntime.obs" class="mt-2" /> 
                </div>  
                <div class="mx-2"> 
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
            <button  onclick="window.location.href='/compressor/downtime'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
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
          maxDate: "{!! $compressordowntime->fecha->format('d-m-Y') !!}"
      
        })
      }) 
 </script>   
