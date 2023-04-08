<div>
    @include('common.alerts');
    @include('common.messages');

    <x-slot name="header_content">
        <h3>Declaraciones Juradas</h3>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">DDJJ</a></div>
            <div class="breadcrumb-item">DDJJ</div>
        </div>
    </x-slot>
    <div class="grid grid-cols-6 md:grid-cols-12 gap-2">
        <div class="col-span-6 md:col-span-3 bg-white-800 p-4 border-2 border-blue-500 border-opacity-100">
            <div>  
                <div>
                    <br>
                    <hr style="width: 100%">
                    <h2 class="text-center">DDJJ a Generar</h2>
                    <hr style="width: 100%">
                </div>    
                <div class="form-group col-span-6 sm:col-span-5">
                    <div class="mx-2">    
                        <x-jet-label for="area_id" value="{{ __('Area:') }}" />
                        <select class="form-select"  style="width: 100%" wire:model.defer="area_id" required autofocus>
                            <option value="--">--Seleccione--</option>                        
                            <option value="1">CCO-NORTE</option>                                           
                        </select>
                        <x-jet-input-error for="area_id" class="mt-2" />   
                    </div>
                </div>  
                <div class="form-group col-span-6 sm:col-span-5">
                    <div class="mx-2">    
                        <x-jet-label for="tipo" value="{{ __('DDJJ a Generar:') }}" />
                        <select class="form-select" wire:model.defer="tipo" style="width: 100%"  required  >
                            <option value="--">--Seleccione--</option>                            
                            <option value="1">Cap. IV</option>   
                            <option value="2">Regalias</option>                                                            
                            <option value="3">Cesco</option>   
                        </select>
                        <x-jet-input-error for="tipo" class="mt-2" />   
                    </div>
                </div>  
  
               
            
                <div class="form-group col-span-2 sm:col-span-5"  id="desde">
                    <div class="mx-2"> 
                        <x-jet-label for="desde" value="{{ __('Desde') }}" />
                        <input type="text" id="desde" class="form-control flatpickr" data-toggle="date" wire:model.defer="desde"  placeholder="Desde" required>
                        <x-jet-input-error for="desde" class="mt-2" />
                    </div>  
                </div>   

                <div class="form-group col-span-2 sm:col-span-5" id="hasta"  >
                    <div class="mx-2"> 
                        <x-jet-label for="hasta" value="{{ __('Hasta') }}" />
                        <input type="text" id="hasta" class="form-control flatpickr" data-toggle="date" wire:model.defer="hasta"  placeholder="Seleccione fecha" required >
                        <x-jet-input-error for="hasta" class="mt-2" />
                    </div> 
                </div> 
                
                        
                <div class="form-group col-span-6 sm:col-span-5">       
                    <div class="mx-2 text-center"> 
                        <button wire:click='calcularDdjj()' class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-magnifying-glass"></i>&nbsp&nbspGenerar</button>
                    </div> 
                </div>          
            
            </div>
            
        </div>
        <div class="col-span-6 md:col-span-9 bg-white-500 p-4 border-2 border-blue-500 border-opacity-100">
        </div>
     </div>    
</div>

@push('js')

    <script>  
        document.addEventListener('DOMContentLoaded', function(){
            flatpickr(document.getElementsByClassName('flatpickr'),{
                enableTime: false,
                dateFormat: 'd-m-Y',
                locale: "es",
            
            })
        }) 
        
    </script> 
@endpush    