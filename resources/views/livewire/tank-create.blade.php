<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
      
        <x-slot name="title">
            {{ __('Tanques') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete todos los campos') }}
        </x-slot>  
           
        <x-slot name="form">
            <x-jet-input id="area_id" type="hidden" value="1" wire:model.defer="tank.area_id" />         
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
               <div class="mx-2"> 
                    <x-jet-label for="nombre" value="{{ __('Nombre') }}" />
                    <x-jet-input id="nombre" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="tank.nombre" />
                    <x-jet-input-error for="nombre" class="mt-2" />
               </div> 
               <div class="mx-2">    
                    <x-jet-label for="capacidad" value="{{ __('Capacidad:') }}" />
                    <x-jet-input id="capacidad" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="tank.capacidad" />
                    <x-jet-input-error for="capacidad" class="mt-2" />
                </div>
    
            </div>    
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">   
                <div class="mx-2">           
                    <div class="mx-2 w-50">           
                        <x-jet-label for="api" value="{{ __('Es Api:') }}" />
                        <select class="form-select" wire:model.defer="tank.api">
                            <option value="--">--Seleccione--</option>
                            <option value="1" @if ('{{$api}}' == 1) selected @endif>Si</option>
                            <option value="0" @if ('{{$api}}' == 0) selected @endif>No</option>                
                        </select>
                        <x-jet-input-error for="tank.api" class="mt-2" />
                    </div>
                </div>
                <div class="mx-2">  
                    <x-jet-label for="cte" value="{{ __('Cte:') }}" />
                    <x-jet-input id="cte" type="number"  step="0.001"   class="mt-1 block w-full form-control shadow-none" wire:model.defer="tank.cte" />
                    <x-jet-input-error for="tank.cte" class="mt-2" />        
                </div>               
            </div>
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">   
                <div class="mx-2">           
                    <x-jet-label for="altura" value="{{ __('Altura:') }}" />
                    <x-jet-input id="altura" type="number" step="0.01"    class="mt-1 block w-full form-control shadow-none" wire:model.defer="tank.altura" />
                    <x-jet-input-error for="tank.altura" class="mt-2" />
                </div>
                <div class="mx-2">  
                    <x-jet-label for="largo" value="{{ __('Largo:') }}" />
                    <x-jet-input id="largo" type="number"  step="0.01"   class="mt-1 block w-full form-control shadow-none" wire:model.defer="tank.largo" />
                    <x-jet-input-error for="tank.largo" class="mt-2" />        
                </div>               
            </div>      
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">   
                <div class="mx-2 w-50">           
                    <x-jet-label for="interno" value="{{ __('Es interno:') }}" />
                    <select class="form-select" wire:model.defer="tank.interno">
                        <option value="--">--Seleccione--</option>
                        <option value="1" @if ('{{$interno}}' == 1) selected @endif>Si</option>
                        <option value="0" @if ('{{$interno}}' == 0) selected @endif>No</option>                
                    </select>
                </div>
                <div class="mx-2">  
                    <x-jet-label for="Estado" value="{{ __('Estado:') }}" />                  
                    <x-jet-input id="estado" type="text"  required validate class="mt-1 block w-full form-control shadow-none" wire:model.defer="tank.estado" />
                    <x-jet-input-error for="estado" class="mt-2" />        
                </div>               
            </div>      
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">   
                <div class="mx-2">           
                    <x-jet-label for="Fabricacion" value="{{ __('Año Fabricación:') }}" />
                    <x-jet-input id="capacidad" type="number" step="1" class="mt-1 block w-full form-control shadow-none" wire:model="tank.fabricacion" />
                    <x-jet-input-error for="tank.fabricacion" class="mt-2" />
                </div>
                <div class="mx-2">  
                    <x-jet-label for="tank.alturaT" value="{{ __('Altura Total:') }}" />
                    <x-jet-input id="alturaT" type="number" step="0.01" class="mt-1 block w-full form-control shadow-none" wire:model.defer="tank.alturaT" />
                    <x-jet-input-error for="tank.alturaT" class="mt-2" />        
                </div>               
            </div>      
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-1 gap-5">   
                 <div class="mx-2">  
                    <x-jet-label for="Obs" value="{{ __('Obs:') }}" />
                     <x-textarea  id="obs" rows="3" cols="30" wire:model.defer="tank.obs" style="width: 100%"/>   
                    <x-jet-input-error for="obs" class="mt-2" />        
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
            <button  onclick="window.location.href='/tank'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button>
        </x-slot>
     
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
