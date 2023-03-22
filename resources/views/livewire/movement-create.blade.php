<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Movimientos') }}
        </x-slot>

        <x-slot name="description">
            {{ __('--') }}
        </x-slot>

        <x-slot name="form">
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="movement.area_id" value="{{ __('Area:') }}" />               
                <select class="form-select" wire:model.defer="movement.area_id" autofocus>
                    <option value="0">--Seleccione--</option>
                    <option value="1">CCO-NORTE</option>                                      
                </select>
                <x-jet-input-error for="movement.area_id" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-5">
                 <x-jet-label for="movement.tipo" value="{{ __('Tipo:') }}" />               
                <select class="form-select" wire:model="movement.tipo" >
                    <option value="">--Seleccione--</option>
                    <option value="mov_int">Movimiento Int.</option>                                      
                    <option value="mov_ext">Movimiento Ext.</option>                                      
                </select>
                <x-jet-input-error for="movement.tipo" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="movement.fecha" value="{{ __('Fecha') }}" />
                <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="movement.fecha" required placeholder="Seleccione fecha">
                <x-jet-input-error for="movement.fecha" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="remito" value="{{ __('Nro. Remito') }}" />
                <x-jet-input id="remito" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="movement.remito" />
                <x-jet-input-error for="movement.remito" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="movement.product_id" value="{{ __('Producto:') }}" />               
                <select class="form-select" wire:model.defer="movement.product_id">
                    <option value="0">--Seleccione--</option>
                @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->nombre}}</option>                  
                @endforeach                                       
                </select>
                <x-jet-input-error for="movement.product_id" class="mb-0" />
            </div>


            @if ($movement->tipo=="mov_int")
                <div class="form-group col-span-6 sm:col-span-5v flex mb-0 bt-0">
                    <x-jet-label for="origen" value="{{ __('Origen:') }}" /> 
                    <div class="form-group col-md-3 pl-2">
                        <input type="radio" checked wire:model="movement.torigen" name="torigen_origen" id="torigent_origen_tank" class="form-check-input" value="T" >
                        <label for="tmovement.torigen">{{ __('Tanque') }}</label>
                    </div>
                    <div class="form-group col-md-3 pl-2 flex-auto">
                        <input type="radio" wire:model="movement.torigen" name="torigen_origen" id="torigent_origen_well" class="form-check-input" value="W" >
                        <label for="movement.torigen">{{ __('Pozo') }}</label>
                    </div>
                    <x-jet-input-error for="movement.torigen" class="mt-2" />
                </div> 
            
                @if($movement->torigen=="T")
                <div class="form-group col-span-6 sm:col-span-5">    
                    <x-jet-label for="movement.tank_id_ori" value="{{ __('Tanque Origen:') }}" /> 
                    <select class="form-select" wire:model.defer="movement.tank_id_ori">
                        <option value="">--Seleccione--</option>
                        @foreach($tanks as $tank)
                            <option value="{{$tank->id}}">{{$tank->nombre}}</option>                  
                        @endforeach                 
                    </select>
                    <x-jet-input-error for="movement.tank_id_ori" class="mb-0" />
                </div>    
                @elseif($movement->torigen=="W")
                <div class="form-group col-span-6 sm:col-span-5">    
                    <x-jet-label for="movement.well_id_ori" value="{{ __('Pozo Origen:') }}" /> 
                    <select class="form-select" wire:model.defer="movement.well_id_ori">
                            <option value="">--Seleccione--</option>
                            @foreach($wells as $well)
                                <option value="{{$well->id}}">{{$well->pozo}}</option>                  
                            @endforeach                 
                    </select>  
                    <x-jet-input-error for="movement.well_id_ori" class="mt-2" /> 
                </div> 
                @endif   
                {{-- Radio buttons Destino  --}}
                <div class="form-group col-span-6 sm:col-span-5v flex mb-0 bt-0">
                    <x-jet-label for="movement.tdestino" value="{{ __('Destino:') }}" /> 
                    <div class="form-group col-md-3 pl-2">
                        <input type="radio" wire:model="movement.tdestino" name="tdestino_destino" id="torigent_destino_tank" class="form-check-input" value="T" >
                        <label for="movement.tdestino">{{ __('Tanque') }}</label>
                    </div>
                    <div class="form-group col-md-3 pl-2 flex-auto">
                        <input type="radio" wire:model="movement.tdestino" name="tdestino_destino" id="torigent_destino_well" class="form-check-input" value="W" >
                        <label for="tdestino_destino">{{ __('Pozo') }}</label>
                    </div>
                    <x-jet-input-error for="movement.tdestino" class="mt-2" /> 
                </div>        
            
                @if($movement->tdestino=="T")
                <div class="form-group col-span-6 sm:col-span-5">    
                    <x-jet-label for="movement.tank_id_ori" value="{{ __('Tanque Destino:') }}" /> 
                    <select class="form-select" wire:model.defer="movement.tank_id_des">
                        <option value="">--Seleccione--</option>
                        @foreach($tanks as $tank)
                            <option value="{{$tank->id}}">{{$tank->nombre}}</option>                  
                        @endforeach                 
                    </select>
                    <x-jet-input-error for="tank_id_des" class="mb-0" />
                </div>    
                @elseif($movement->tdestino=="W")
                <div class="form-group col-span-6 sm:col-span-5">    
                    <x-jet-label for="movement.tank_id_ori" value="{{ __('Pozo Destino:') }}" /> 
                    <select class="form-select" wire:model.defer="movement.well_id_des">
                            <option value="0">--Seleccione--</option>
                            @foreach($wells as $well)
                                <option value="{{$well->id}}">{{$well->pozo}}</option>                  
                            @endforeach                 
                    </select>  
                    <x-jet-input-error for="movement.well_id_des" class="mt-2" /> 
                </div> 
                @endif          
        
               
            @elseif($movement->tipo=="mov_ext")
                <div class="form-group col-span-6 sm:col-span-5">
                    <x-jet-label for="movement.client_id" value="{{ __('Cliente:') }}" />               
                    <select class="form-select" wire:model.defer="movement.client_id">
                        <option value="0">--Seleccione--</option>
                    @foreach($clients as $client)
                        <option value="{{$client->id}}">{{$client->nombre}}</option>                  
                    @endforeach                                       
                    </select>
                    <x-jet-input-error for="movement.client_id" class="mt-2" />
                </div>
                <div class="form-group col-span-6 sm:col-span-5v flex mb-0 bt-0">
                    <x-jet-label for="origen" value="{{ __('Destino:') }}" /> 
                    <div class="form-group col-md-3 pl-2">
                        <input type="radio" checked wire:model="movement.tdestino" name="tdestino" id="tdestinot" class="form-check-input" value="T">
                        <label for="iscompany_yes">{{ __('Tanque') }}</label>
                    </div>
                    <div class="form-group col-md-3 pl-2 flex-auto">
                        <input type="radio" wire:model="movement.tdestino" name="tdestino" id="tdestinow" class="form-check-input" value="W" >
                        <label for="iscompany_no">{{ __('Pozo') }}</label>
                    </div>
                </div>        
                @if($movement->tdestino=="T")
                <div class="form-group col-span-6 sm:col-span-5">    
                    <x-jet-label for="origen" value="{{ __('Tanque Destino:') }}" /> 
                    <select class="form-select" wire:model.defer="movement.tank_id_des">
                        <option value="">--Seleccione--</option>
                        @foreach($tanks as $tank)
                            <option value="{{$tank->id}}">{{$tank->nombre}}</option>                  
                        @endforeach                 
                    </select>
                    <x-jet-input-error for="movement.tank_id_des" class="mb-0" />
                </div>    
                @elseif($movement->tdestino=="W")
                <div class="form-group col-span-6 sm:col-span-5">    
                    <x-jet-label for="origen" value="{{ __('Pozo Destino:') }}" /> 
                    <select class="form-select" wire:model.defer="movement.well_id_des">
                        <option value="0">--Seleccione--</option>
                        @foreach($wells as $well)
                        <option value="{{$well->id}}">{{$well->pozo}}</option>                  
                        @endforeach                        
                    </select> 
                    <x-jet-input-error for="movement.well_id_des" class="mt-2" />  
                </div> 
                @endif               
        
                          
            @endif

            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="movement.volumen" value="{{ __('Volumen (mt3)') }}" />
                <x-jet-input id="volumen" type="number" step="0.01" class="mt-1 block w-full form-control shadow-none" wire:model.defer="movement.volumen"  required/>
                <x-jet-input-error for="movement.volumen" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-5">
                <x-jet-label for="movement.obs" value="{{ __('Observaciones') }}" />
                <x-textarea  id="obs" rows="3" cols="30" wire:model.defer="movement.obs" style="width: 100%"/>
               <x-jet-input-error for="movement.obs" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __($button['submit_text']) }}
            </x-jet-button>
            <button  onclick="window.location.href='/movement'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
            
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
      
        })
      }) 
</script>  