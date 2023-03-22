<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('Ventas') }}
        </x-slot>

        <x-slot name="description">
            {{ __('--') }}
        </x-slot>     
        <x-slot name="form"> 
                <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="mx-2"> 
                        <x-jet-label for="area_id" value="{{ __('Area:') }}" />               
                        <select id="area_id" class="form-select" wire:model.defer="sale.area_id" style="width: 100%" >
                            <option value="0">--Seleccione--</option>
                            <option value="1">CCO-NORTE</option>                                      
                        </select>
                        <x-jet-input-error for="sale.area_id" class="mt-2" />
                    </div>
    
                    <div class="mx-2"> 
                        <x-jet-label for="fecha" value="{{ __('Fecha') }}" />
                        <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="sale.fecha" required placeholder="Seleccione fecha">
                        <x-jet-input-error for="sale.fecha" class="mt-2" />
                    </div>       
                </div>    

                <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="mx-2">    
                        <x-jet-label for="remito" value="{{ __('Nro. Remito:') }}" />
                        <x-jet-input id="remito" type="text" maxlength="13" class="mt-1 block w-full form-control shadow-none" wire:model.defer="sale.remito" />
                        <x-jet-input-error for="sale.remito" class="mt-2" />
                    </div>
                    <div class="mx-2"> 
                        <x-jet-label for="product_id" value="{{ __('Producto') }}" />
                        <select class="form-select" wire:model.defer="sale.product_id" style="width: 100%">
                            <option value="--">--Seleccione--</option>
                            @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->nombre}}</option>   
                            @endforeach                                   
                        </select>
                        <x-jet-input-error for="sale.product_id" class="mt-2" />
                    </div>    
                </div> 

                <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="mx-2">    
                        <x-jet-label for="tank_id" value="{{ __('Tanque') }}" />
                        <select id="tank_id" class="form-select" wire:model.defer="sale.tank_id"  style="width: 100%" onchange="getTankCapacity(this);" required>
                            <option value="--">--Seleccione--</option>
                            @foreach($tanks as $tank)
                            <option value="{{$tank->id}}">{{$tank->nombre}}  - ({{$tank->capacidad}} )</option>   
                            @endforeach                                   
                        </select>
                        <x-jet-input-error for="sale.tank_id" class="mt-2" />
                    </div>
                    <div class="mx-2"> 
                        <x-jet-label for="total" value="{{ __('Cantidad Mt3') }}" />
                        <x-jet-input id="total" type="number" step="0.01" max="{{$tank->capacidad}}" class="mt-1 block w-full form-control shadow-none" wire:model.defer="sale.total" />
                        <x-jet-input-error for="sale.total" class="mt-2" />
                    </div>            
                </div> 

                <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="mx-2"> 
                        <x-jet-label for="total" value="{{ __('% Agua') }}" />
                        <x-jet-input id="total" type="number" step="0.01" min="0.01" max="100" class="mt-1 block w-full form-control shadow-none" wire:model.defer="sale.aguaporce" />
                        <x-jet-input-error for="sale.aguaporce" class="mt-2" />
                       
                    </div>            
                    <div class="mx-2"> 
                        <x-jet-label for="obs" value="{{ __('Observaciones') }}" />
                        <x-textarea  id="obs" rows="3" cols="30" wire:model.defer="sale.obs" style="width: 100%"/>
                        <x-jet-input-error for="sale.obs" class="mt-2" /> 
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
            <button  onclick="window.location.href='/sale'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
               
        </x-slot>
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
<script>
    window.onload = function () {
        var tank = $('#tank_id').find(":selected").text()  
        var cap = tank.split('-');  
        var cap = tank.split('-');       
        cap[1]=cap[1].replace('(', '');
        cap[1]=cap[1].replace(')', '');  
        cap[1].trim();  
        $("#total").attr('max',cap[1])        

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
         maxDate: "{!! $sale->fecha->format('d-m-Y') !!}"
     
       })   
     
     })

  
</script>   
<script>
    function getTankCapacity(idTank){     
        var tank = $('#tank_id').find(":selected").text()      
        var capacidad = tank.split('-');       
        capacidad[1]=capacidad[1].replace('(', '');
        capacidad[1]=capacidad[1].replace(')', '');       
        $("#total").attr('max',capacidad[1])        
     }
</script>   
 
