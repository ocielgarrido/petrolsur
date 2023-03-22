<div id="form-create" :submit="$action" class="mb-4">
    @include('common.messages')
    @include('common.alerts')

    <x-jet-form-section :submit="null" class="mb-4">
        <x-slot name="title">
            {{ __('Mediciones') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Todos los campos son obligatorios') }}
            <p class="text-danger">Importante.</p>
            <p class="text-danger">Para un correcto cálculo, asegúrese de tener cargado un control de Tanque.</p>
            <p class="text-danger">si aún no ha cargado un control haga click en siguiente enlace.</p>
            <a href="{{ route('tankcontrol.create') }}">Click acá </a>
        </x-slot>  
  
        <x-slot name="form"> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="mx-2">           
                    <x-jet-label for="api" value="{{ __('Area:') }}" />               
                    <select class="form-select" style="width:100%" wire:model.defer="oil.area_id" disabled>
                        <option value="1">CCO-NORTE</option>                                      
                    </select>
                </div>
                <div class="mx-2">           
                    <x-jet-label for="fecha" value="{{ __('Fecha:') }}"/>
                    <input type="text" class="form-control flatpickr" data-toggle="date" wire:model.defer="oil.fecha" required placeholder="Seleccione fecha"  disabled="{{ $isDisabled }}">
                    <x-jet-input-error for="oil.fecha" class="mt-2" />
                </div>  
            </div> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="mx-2">           
                    <x-jet-label for="oil.tankId" value="{{ __('Tanque:') }}" />               
                    <select class="form-select" wire:model.defer="oil.tankId" wire:change='verificaControl' >
                        <option value="--">--Seleccione--</option>
                        @foreach($tanks as $tank)
                        <option value="{{$tank->id}}">{{$tank->nombre}}</option>   
                        @endforeach                                   
                    </select>
                    <x-jet-input-error for="oil.tankId" class="mt-2" />    
                </div>
                <div class="mx-2">           
                    <x-jet-label for="oil.altura" value="{{ __('Altura (cms):') }}" />
                    <x-jet-input id="altura" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="oil.altura" />
                    <x-jet-input-error for="oil.altura" class="mt-2" />        
                     </div>  
                <div class="mx-2">           
                    <x-jet-label for="corte_agua" value="{{ __('Agua (cms):') }}" />
                    <x-jet-input id="corte_agua" type="number"   class="mt-1 block w-full form-control shadow-none" wire:model.defer="oil.corte_agua" />
                    <x-jet-input-error for="oil.corte_agua" class="mt-2" />        
                </div>  
               <div class="mx-2">    
                    <x-jet-label for="corte_agua" value="{{ __('Accion:') }}" />     
                    <button class="btn btn-danger" wire:click.prevent="addDetalOil()" ><i class="fa fa-16px fa-check"></i>&nbspAgregar</button>
                </div>       
             </div> 
            <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-1 gap-2">
                    <table class="table table-bordered table-striped text-sm text-gray-600" style="width:100%">
                        <thead>
                            <th class="hidden">#</th>
                            <th >Tanque</th>
                            <th >Alt.</th>
                            <th >Agua</th>
                            <th >V.Agua</th>
                            <th >V.Oil.H</th>
                            <th >V.Oil.D.</th>
                            <th >V.Total</th>
                            <th >&nbsp;</th>
                        </thead>
                        <tbody>                       
                            @foreach($detailTank as $key => $tanks)
                                <tr class="text-center" wire:key="{{$key}}">
                                    <td class="hidden" >{{$key+1}}</td> 
                                    <td class="text-left">{{$tanks['nombre']}}</td> 
                                    <td class="text-left">{{$tanks['altura']}}</td> 
                                    <td class="text-left">{{$tanks['corte_agua']}}</td> 
                                    <td class="text-left">{{$tanks['agua']}}</td> 
                                    <td class="text-left">{{$tanks['oil']}}</td> 
                                    <td class="text-left">{{$tanks['oil_des']}}</td> 
                                    <td class="text-left">{{$tanks['total']}}</td> 
                                    <td class="text-center"><button class="btn btn-danger bnt-sm" wire:click.prevent="removeItem({{$key}})">x</button></td> 
                                </tr>
                             @endforeach                            
                        </tbody> 
                        <tfoot>
                            <td colspan="8" class="text-center" > 
                                <button class="btn btn-success  {{$isvisible == 1 ? 'visible' :'hidden'}}" wire:click.prevent="storeProduction()" ><i class="fa fa-16px fa-check">&nbsp&nbspGuardar Parte</i></button>
                                <button class="btn btn-success  {{$isvisible == 0 ? 'visible' :'hidden'}}" wire:click.prevent="updateProduction()" ><i class="fa fa-16px fa-check">&nbspActualizar Parte</i></button>
                                <button  onclick="window.location.href='/oil'" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</button> 
                           </td> 
                        </tfoot>   
                    </table>    
             </div> 
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>
                      
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
          maxDate: "{!! $oil->fecha->format('d-m-Y') !!}"
      
        })
      }) 
</script>  
