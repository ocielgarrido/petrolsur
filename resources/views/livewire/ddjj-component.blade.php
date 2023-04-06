<div>
    <div class="col-span-6 md:col-span-3 bg-white-800 p-4 border-2 border-blue-500 border-opacity-100">
        <div>  
            <div >
                <br>
                <hr style="width: 100%">
                <h2 class="text-center">Reportes</h2>
                <hr style="width: 100%">
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
            <div class="form-group col-span-6 sm:col-span-5" id="wells"  >
                <div class="mx-2"> 
                    <x-jet-label for="wellId" value="{{ __('Pozo') }}" />
                    <select class="form-select" wire:model.defer="wellId" style="width: 100%"   >
                        <option value="--">--Seleccione--</option>
                        <option value="0">Todos</option>
                        @foreach($wells as $well)
                        <option value="{{$well->id}}">{{$well->pozo}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="report.well_id" class="mt-2" />   
                </div> 
            </div> 
                    
            <div class="form-group col-span-6 sm:col-span-5">       
                <div class="mx-2 text-center"> 
                    <button wire:click='calcularDdjj()' class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-magnifying-glass"></i>&nbsp&nbspVisualizar</button>
                </div> 
            </div>          
        
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