<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">      
        <x-slot name="title">
            {{ __('Controles') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete todos los campos') }}
        </x-slot>  
           
        <x-slot name="form">   
            @include('common.alerts');
            @include('common.messages');
               
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2"> 
                     <x-jet-label for="area_id" value="{{ __('Area:') }}" />               
                     <select id="area_id" class="form-select" wire:model.defer="wellcontrol.area_id" style="width: 100%" >
                        <option value="0">--Seleccione--</option>
                        <option value="1">CCO-NORTE</option>                                      
                    </select>
                    <x-jet-input-error for="wellcontrol.area_id" class="mt-2" />
                </div>
                <div class="mx-2"> 
                    <x-jet-label for="well" value="{{ __('Pozo') }}" />
                    <select id="well_id" class="form-select" wire:model.defer="wellcontrol.well_id" required style="width: 100%">
                        <option value="--">--Seleccione--</option>
                        @foreach($wells as $well)
                        <option value="{{$well->id}}">{{$well->pozo}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="wellcontrol.well_id" class="mt-2" />                    
               </div>   
    
            </div>    
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2">           
                    <x-jet-label for="fecha" value="{{ __('Fecha:') }}" />                       
                    <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="wellcontrol.fecha" required   placeholder="Seleccione fecha">
                    <x-jet-input-error for="wellcontrol.fecha" class="mt-2" />               
                </div>
  
                <div class="mx-2">           
                    <x-jet-label for="horas" value="{{ __('Horas:') }}" />
                    <x-jet-input id="horas" type="number" step="1"  min="1" max="24" class="mt-1 block w-full form-control shadow-none" onblur="Calcular();" wire:model.defer="wellcontrol.horas" required />
                    <x-jet-input-error for="wellcontrol.horas" class="mt-2" />
                </div>
           </div> 
           <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="prod_bruta_mt3" value="{{ __('Producción Bruta mt3') }}" />
                        <x-jet-input id="prod_bruta_mt3" type="number" step="any" onchange="Calcular();" class="mt-1 block w-full form-control shadow-none" onblur="Calcular();" wire:model.defer="wellcontrol.prod_bruta_mt3" required />
                        <x-jet-input-error for="wellcontrol.prod_bruta_mt3" class="mt-2" /> 
                </div> 

                 <div class="mx-2"> 
                    <x-jet-label for="gas_neto_mt3" value="{{ __('Gas Producido mt3') }}" />
                    <x-jet-input id="gas_neto_mt3" type="number"  class="mt-1 block w-full form-control shadow-none" onblur="Calcular();"  wire:model.defer="wellcontrol.gas_neto_mt3" required/>
                    <x-jet-input-error for="wellcontrol.gas_neto_mt3" class="mt-2" /> 
                </div>
 
            </div> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="agua_emul_por" value="{{ __('Agua Emulsionada %') }}" />
                    <x-jet-input id="agua_emul_por" type="number" step="any" max="100" onblur="Calcular();" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.agua_emul_por"  required />
                    <x-jet-input-error for="wellcontrol.agua_emul_por" class="mt-2" /> 
                </div>
 
                <div class="mx-2"> 
                    <x-jet-label for="gas_inyectado" value="{{ __('Gas inyectado') }}" />
                    <x-jet-input id="gas_inyectado" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.gas_inyectado" required/>
                    <x-jet-input-error for="wellcontrol.gas_inyectado" class="mt-2" /> 
                </div>
            </div>   
 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="oil_neto_mt3" value="{{ __('Petroleo Neto ') }}" />
                    <x-jet-input id="oil_neto_mt3"  name="oil_neto_mt3" type="text" value="" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.oil_neto_mt3"  disabled required />
                    <x-jet-input-error for="wellcontrol.oil_neto_mt3" class="mt-2" /> 
                </div>    
                <div class="mx-2"> 
                    <x-jet-label for="agua_neto_mt3" value="{{ __('Agua Neta ') }}" />
                    <x-jet-input id="agua_neto_mt3" name="agua_neto_mt3" type="text" value="" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.agua_neto_mt3" disabled required />
                    <x-jet-input-error for="wellcontrol.agua_neto_mt3" class="mt-2" /> 
                </div>    
            </div> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="oil_neto_24" value="{{ __('Petroleo Neto 24 hr') }}" />
                    <x-jet-input id="oil_neto_24"  name="oil_neto_24" type="text" value="" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.oil_neto_24"  disabled required />
                    <x-jet-input-error for="wellcontrol.oil_neto_24" class="mt-2" /> 
                </div>    
                <div class="mx-2"> 
                    <x-jet-label for="agua_neto_24" value="{{ __('Agua Neta 24 hr') }}" />
                    <x-jet-input id="agua_neto_24" name="agua_neto_24" type="text" value="" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.agua_neto_24" disabled required />
                    <x-jet-input-error for="wellcontrol.agua_neto_24" class="mt-2" /> 
                </div>    
            </div> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="gas_neto_24" value="{{ __('Gas Neto 24 hr') }}" />
                    <x-jet-input id="gas_neto_24"  name="gas_neto_24" type="text" value="" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.gas_neto_24"  disabled required />
                    <x-jet-input-error for="wellcontrol.gas_neto_24" class="mt-2" /> 
                </div>    
                <div class="mx-2"> 
                    <x-jet-label for="prod_bruta_24" value="{{ __('Producción Bruta 24 hr') }}" />
                    <x-jet-input id="prod_bruta_24" name="agua_neto_mt3" type="text" value="" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.prod_bruta_24" disabled required />
                    <x-jet-input-error for="wellcontrol.prod_bruta_24" class="mt-2" /> 
                </div>    
            </div> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="gor" value="{{ __('Gor') }}" />
                    <x-jet-input id="gor"  name="gor" type="text" value="" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.gor"  disabled required />
                    <x-jet-input-error for="wellcontrol.gor" class="mt-2" /> 
                </div>  
                <div class="mx-2"> 
                    <x-jet-label for="carrera" value="{{ __('Carrera') }}" />
                    <x-jet-input id="carrera" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.carrera" required/>
                    <x-jet-input-error for="wellcontrol.carrera" class="mt-2" /> 
                </div>
   
            </div>                 
              <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5"> 
                <div class="mx-2"> 
                    <x-jet-label for="gpm" value="{{ __('Golpes por min.') }}" />
                    <x-jet-input id="gpm" type="number" step="0.01" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.gpm" required />
                    <x-jet-input-error for="wellcontrol.gpm" class="mt-2" /> 
                </div>    

                <div class="mx-2"> 
                    <x-jet-label for="orificio" value="{{ __('Orificio') }}" />
                    <x-jet-input id="orificio" type="number" step="0.1" class="mt-1 block w-full form-control shadow-none" wire:model.defer="wellcontrol.orificio" required />
                    <x-jet-input-error for="wellcontrol.orificio" class="mt-2" /> 
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
            <button  onclick="window.location.href='/wellcontrol'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
        </x-slot>
     
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>

<script>
   function Calcular(){ 
    var bruta=document.getElementById('prod_bruta_mt3'); //la que se carga
    var agua_porce=document.getElementById('agua_emul_por'); //se carga
    var agua_neto=document.getElementById('agua_neto_mt3');
    var oil_neto =document.getElementById('oil_neto_mt3');
    var gas_neto =document.getElementById('gas_neto_mt3');
    
    var horas=document.getElementById('horas'); //se carga
    var bruta24=document.getElementById('prod_bruta_24'); //la que se carga
    var agua_neto24=document.getElementById('agua_neto_24');
    var oil_neto24 =document.getElementById('oil_neto_24');
    var gas_neto24 =document.getElementById('gas_neto_24');
    var gor =document.getElementById('gor');

 //    alert(bruta.value + '-' horas.value + '-' + agua_porce.value);
    if( bruta.value >0 && agua_porce.value>0 && horas.value>0 ) {
        agua_neto.value=(bruta.value*agua_porce.value/100).toFixed(2);
        oil_neto.value=(bruta.value-agua_neto.value).toFixed(2);

        bruta24.value= (bruta.value/horas.value*24).toFixed(2); 
        agua_neto24.value=(bruta24.value*agua_porce.value/100).toFixed(2);        
        oil_neto24.value=(bruta24.value-agua_neto24.value).toFixed(2);
        gas_neto24.value=gas_neto.value/horas.value*24;
        if ( oil_neto24.value!=0 && gas_neto24.value!=0){
          gor.value=(gas_neto24.value / oil_neto24.value).toFixed(2);
        } else{
          gor.value=0; 
        }
        agua_neto.value.replace(".", ",");
        oil_neto.value=oil_neto.value.replace(",", ".");
        agua_neto.value=agua_neto.value.replace(",", ".");       
  
    }else{
        oil_neto.value=0;
        agua_neto.value=0; 
        oil_neto24.value=0;
        bruta24.value=0;     
        agua_neto24.value=0;
        gas_neto24=0; 
        gor=0;      

    }

   }
</script> 

<script>
 //   $wellcontrol->fecha
document.addEventListener('DOMContentLoaded', function(){
    flatpickr(document.getElementsByClassName('flatpickr'),{
      enableTime: false,
      dateFormat: 'd-m-Y',
      locale: "es",
      minDate: "{!! $primerDia !!}",
      maxDate: "{!! $wellcontrol->fecha->format('d-m-Y') !!}"
  
    })
  })

 
</script>   