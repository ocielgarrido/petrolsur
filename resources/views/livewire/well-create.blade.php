<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
      
        <x-slot name="title">
            {{ __('Pozos') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete todos los campos') }}
        </x-slot>  
           
        <x-slot name="form">
          
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-4 gap-1">
                <div class="mx-1">    
                    <x-jet-label for="well.area_id" value="{{ __('Area:') }}" />
                    <select class="form-select" wire:model.defer="well.area_id" >
                        <option value="--">--Seleccione--</option>                        
                        <option value="1">CCO-NORTE</option>                                                   
                    </select>
                    <x-jet-input-error for="well.area_id" class="mt-2" />   
                </div>
                <div class="mx-1"> 
                    <x-jet-label for="well.idpozo" value="{{ __('ID Pozo') }}" />                    
                    <x-jet-input id="id" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.idpozo" />
                    <x-jet-input-error for="well.idpozo" class="mt-2" />
                </div> 
                <div class="mx-1"> 
                    <x-jet-label for="well.pozo" value="{{ __('Nombre') }}" />                    
                    <x-jet-input id="pozo" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.pozo" />
                    <x-jet-input-error for="well.pozo" class="mt-2" />
               </div> 
               <div class="mx-1">    
                    <x-jet-label for="yacimiento" value="{{ __('Yacimiento:') }}" />
                    <select class="form-select" wire:model.defer="well.yacimiento_id" >
                        <option value="--">--Seleccione--</option>
                        @foreach($yacimientos as $yacimiento)
                        <option value="{{$yacimiento->id}}">{{$yacimiento->yac_artiv}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="well.yacimiento_id" class="mt-2" />   
                </div>

    
            </div>  

            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-4 gap-1"> 
                <div class="mx-1">    
                    <x-jet-label for="capacidad" value="{{ __('Formación:') }}" />
                    <select class="form-select" wire:model.defer="well.well_formation_id" >
                        <option value="--">--Seleccione--</option>
                        @foreach($formations as $formation)
                        <option value="{{$formation->id}}">{{$formation->nombre}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="well.well_formation_id" class="mt-2" />   
                </div>   
                <div class="mx-1">           
                    <x-jet-label for="cap_iv_nombre" value="{{ __('Nombre Cap. IV:') }}" />                       
                    <x-jet-input id="cap_iv_nombre" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.cap_iv_nombre" />
                    <x-jet-input-error for="well.cap_iv_nombre" class="mt-2" />               
                </div>
                <div class="mx-1">           
                    <x-jet-label for="cota" value="{{ __('Cota:') }}" />
                    <x-jet-input id="cota" type="number" step="0.01"    class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.cota" />
                    <x-jet-input-error for="well.cota" class="mt-2" />
                </div>
                <div class="mx-1">  
                    <x-jet-label for="profundidad" value="{{ __('Profundidad:') }}" />
                    <x-jet-input id="profundidad" type="number"  step="0.01"   class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.profundidad" />
                    <x-jet-input-error for="well.profundidad" class="mt-2" />        
                </div>               

            </div>

            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-4 gap-1">   
                <div class="mx-1">           
                    <x-jet-label for="latitud" value="{{ __('Latitud:') }}" />
                    <x-jet-input id="latitud" type="text"    class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.latitud" />
                    <x-jet-input-error for="well.latitud" class="mt-2" />
                </div>
                <div class="mx-1">  
                    <x-jet-label for="longitud" value="{{ __('Longitud:') }}" />
                    <x-jet-input id="longitud" type="text"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.longitud" />
                    <x-jet-input-error for="well.longitud" class="mt-2" />        
                </div>               
                <div class="mx-1">           
                    <x-jet-label for="cord_x" value="{{ __('X:') }}" />
                    <x-jet-input id="cord_x" type="number" step="0.01"    class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.cord_x" />
                    <x-jet-input-error for="well.cord_x" class="mt-2" />
                </div>
                <div class="mx-1">  
                    <x-jet-label for="cord_y" value="{{ __('Y:') }}" />
                    <x-jet-input id="cord_y" type="number"  step="0.01"   class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.cord_y" />
                    <x-jet-input-error for="well.cord_y" class="mt-2" />        
                </div> 
            </div> 

  
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-4 gap-1">   
                <div class="mx-1">           
                    <x-jet-label for="perfo_ini" value="{{ __('Ini. perforación:') }}" />
                    <x-jet-input id="perfo_ini" type="date"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.perfo_ini" />
                    <x-jet-input-error for="well.perfo_ini" class="mt-2" />        
                    
                </div>
                <div class="mx-1">  
                    <x-jet-label for="perfo_fin" value="{{ __('Fin perforación:') }}" />
                    <x-jet-input id="perfo_fin" type="date"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.perfo_fin" />
                    <x-jet-input-error for="well.perfo_fin" class="mt-2" />        
                </div>               
                <div class="mx-1">           
                    <x-jet-label for="termi_ini" value="{{ __('Ini. Terminacion:') }}" />
                    <x-jet-input id="termi_ini" type="date"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.termi_ini" />
                    <x-jet-input-error for="well.termi_ini" class="mt-2" />        
                    
                </div>
                <div class="mx-1">  
                    <x-jet-label for="termi_fin" value="{{ __('Fin Terminación:') }}" />
                    <x-jet-input id="termi_fin" type="date"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.termi_fin" />
                    <x-jet-input-error for="well.termi_fin" class="mt-2" />        
                </div>               
            </div>      

            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-4 gap-1">   
                <div class="mx-1">           
                    <x-jet-label for="prod_oil_dic" value="{{ __('Prod. Oil. 2005:') }}" />
                    <x-jet-input id="prod_oil_dic" type="number"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.prod_oil_dic" />
                    <x-jet-input-error for="well.prod_oil_dic" class="mt-2" />        
                    
                </div>
                <div class="mx-1">  
                    <x-jet-label for="prod_gas_dic" value="{{ __('Prod. Gas 2005:') }}" />
                    <x-jet-input id="prod_gas_dic" type="number"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.prod_gas_dic" />
                    <x-jet-input-error for="well.prod_gas_dic" class="mt-2" />        
                </div>               
                <div class="mx-1">           
                    <x-jet-label for="prod_agua_dic" value="{{ __('Prod. Agua 2005:') }}" />
                    <x-jet-input id="prod_agua_dic" type="number"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.prod_agua_dic" />
                    <x-jet-input-error for="well.prod_agua_dic" class="mt-2" />        
                    
                </div>
                <div class="mx-1">  
                    <x-jet-label for="vida_util_dic" value="{{ __('Vida Util 2005:') }}" />
                    <x-jet-input id="vida_util_dic" type="number" step="1"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.vida_util_dic" />
                    <x-jet-input-error for="well.vida_util_dic" class="mt-2" />        
                </div>               
            </div> 

            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-4 gap-1">   
                <div class="mx-1">           
                    <x-jet-label for="iny_agua_dic" value="{{ __('Iny. Agua 2005:') }}" />
                    <x-jet-input id="iny_agua_dic" type="number"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.iny_agua_dic" />
                    <x-jet-input-error for="well.iny_agua_dic" class="mt-2" />        
                    
                </div>
                <div class="mx-1">  
                    <x-jet-label for="iny_gas_dic" value="{{ __('Iny. Gas 2005:') }}" />
                    <x-jet-input id="iny_gas_dic" type="number"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.iny_gas_dic" />
                    <x-jet-input-error for="well.iny_gas_dic" class="mt-2" />        
                </div>               
                <div class="mx-1">           
                    <x-jet-label for="iny_co_dic" value="{{ __('Iny. CO2 2005:') }}" />
                    <x-jet-input id="iny_co_dic" type="number"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.iny_co_dic" />
                    <x-jet-input-error for="well.iny_co_dic" class="mt-2" />        
                    
                </div>
                <div class="mx-1">  
                    <x-jet-label for="iny_otr_dic" value="{{ __('Iny. Otros 2005:') }}" />
                    <x-jet-input id="iny_otr_dic" type="number" step="1"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.iny_otr_dic" />
                    <x-jet-input-error for="well.iny_otr_dic" class="mt-2" />        
                </div>               
            </div>      

           <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-5 gap-1">   
                <div class="mx-1">           
                    <x-jet-label for="well.abandono" value="{{ __('F. Abandono:') }}" />
                    <x-jet-input id="abandono" type="date"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.abandono" />
                    <x-jet-input-error for="well.abandono" class="mt-2" />                    
                </div>
                <div class="mx-1">           
                    <x-jet-label for="capacidad" value="{{ __('Capacidad:') }}" />
                    <x-jet-input id="capacidad" type="number"  class="mt-1 block w-full form-control shadow-none" wire:model.defer="well.capacidad" />
                    <x-jet-input-error for="well.capacidad" class="mt-2" />                    
                </div>
                <div class="mx-1">  
                    <x-jet-label for="tipo" value="{{ __('Tipo:') }}" />
                    <select class="form-select" wire:model.defer="well.tipo" >
                        <option value="--">--Seleccione--</option>                       
                        <option value="GAS">Gas</option>   
                        <option value="PET">Petróleo</option>                                  
                    </select>
                    <x-jet-input-error for="well.TIPO" class="mt-2" />   
                </div>               
                <div class="mx-1">  
                    <x-jet-label for="capacidad" value="{{ __('Estado:') }}" />
                    <select class="form-select" wire:model.defer="well.well_state_id" >
                        <option value="--">--Seleccione--</option>
                        @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->codigo . ' - ' .$state->descrip}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="well.well_state_id" class="mt-2" />   
                </div>  
                <div class="mx-1">  
                    <x-jet-label for="well.arap" value="{{ __('Tipo Ext.:') }}" />
                    <select class="form-select" wire:model.defer="well.arap" >
                        <option value="">--Seleccione--</option>                       
                        <option value="-">(Ninguno)</option>   
                        <option value="OTE">Otros Tipos de Extracción</option>                                  
                        <option value="PL">Plunger Lift</option>                                  
                        <option value="BM">Bombeo Mecanico</option>                                  
                        <option value="BCP">Cavidad progresiva</option>                                  
                        <option value="SN">Surgencia Natural</option>                                  
                        <option value="GL">Gas Lift</option>                                  
                        <option value="GL">Auto Gas Lift</option>                                  
                        <option value="BES">Electrosumergible</option>                                  
                        <option value="SSE">Sin Sistema de Extracción</option>                                  
                        <option value="BH">Bombeo Hidráulico</option>                                  
                        <option value="PIST">Pistoneo (Swabbing)</option>                                  
                        <option value="JP">Jet Pump</option>                                  
                    </select>
                    <x-jet-input-error for="well.arap" class="mt-2" />   
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
            <button  onclick="window.location.href='/well'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
        </x-slot>
  
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
