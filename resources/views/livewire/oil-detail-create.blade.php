<div>
    @if ($showData==true)

    <div class="table-responsive">
        @if (session()->has('success'))          
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
            <div>
                <strong>{{session('success')}}</strong>
            </div>
          </div>
        @endif
        @if (session()->has('error'))
        <div class="alert alert-danger">
            <strong>{{session('error')}}</strong>
        </div>
        @endif
        <div class="alert alert-danger">
            <strong>Atencin: al modificar medidas, se recalculará produccion dia: {{$fecha->format('d-m-Y')}}  </strong>
        </div>
       <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="color-abel">id</th>
                    <th class="color-abel">Tanque</th>
                    <th class="color-abel">Altura</th>
                    <th class="color-abel">C.Agua</th>
                    <th class="color-abel">Oil</th>                        
                    <th class="color-abel">Oil D.</th>                        
                    <th class="color-abel">Agua</th>
                    <th class="color-abel">Total</th>
                    <th class="color-abel">Accion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($oildetails as $oildetail)
                <tr>
                    <td>{{$oildetail->id}}</td>
                    <td>{{$oildetail->tank->nombre}}</td>
                    <td>{{$oildetail->altura}}</td>
                    <td>{{$oildetail->corte_agua}}</td>
                    <td>{{$oildetail->oil}}</td>
                    <td>{{$oildetail->oil_des}}</td>
                    <td>{{$oildetail->agua}}</td>
                    <td>{{$oildetail->total}}</td>
                    <td><button id="edit"  wire:click='edit({{$oildetail->id}})'><i class="fa fa-16px fa-pen"></button></td>

                </tr>
                @empty
                <h3 class="text-danger">No se encontraron registros</h3>
                @endforelse

            </tbody>
        </table>
    </div>
    @endif
    @if ($updateData == true)
    <div class="row mt-3">
        <div class="col-xl-8 col-md-8 col-sm-12 offset-xl-2 offset-md-2 offset-sm-0">
           <div class="card ">
                    @include('common.alerts')
                    @include('common.messages')
    
                <div class="card-header">
                    <h3 class="text-danger">Actualizar Medidas Tanque {{$tanque}} Dia: {{$fecha->format('d-m-Y')}}</h3>
                </div>
                
                    <div class="card-body">
                        <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="mx-2">           
                                <x-jet-label for="tank_id" value="{{ __('Tanque:') }}" />               
                                <select class="form-select" wire:model.defer="tank_id">
                                    <option value="--">--Seleccione--</option>
                                    @foreach($tanks as $tank)
                                    <option value="{{$tank->id}}">{{$tank->nombre}}</option>   
                                    @endforeach                                   
                                </select>
                                <x-jet-input-error for="tankId" class="mt-2" />                               
                           
                            </div>          
                            <div class="mx-2">           
                                <x-jet-label for="altura" value="{{ __('Altura (cms):') }}" />
                                <x-jet-input id="altura" type="number" step="0.01" class="mt-1 block w-full form-control shadow-none" wire:model.defer="altura" style="width: 100%"/>
                                <x-jet-input-error for="altura" class="mt-2" />        
                             </div>  
                            <div class="mx-2">           
                                <x-jet-label for="corte_agua" value="{{ __('Agua (cms):') }}" />
                                <x-jet-input id="corte_agua" type="number"  step="0.01" class="mt-1 block w-full form-control shadow-none" wire:model.defer="corte_agua" style="width: 100%"/>
                                <x-jet-input-error for="corte_agua" class="mt-2" />        
                            </div>  
                        </div>
                        <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="mx-2">           
                                <x-jet-label for="vOil" value="{{ __('Vol. Oil (mt3):') }}" />
                                <x-jet-input id="vOil" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="vOil" style="width: 100%" disabled/>
                                <x-jet-input-error for="vOil" class="mt-2" />        
                            </div>  
                            <div class="mx-2">           
                                <x-jet-label for="vOil_des" value="{{ __('Vol. Oil Des. (mt3):') }}" />
                                <x-jet-input id="vOil_des" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="vOil_des" style="width: 100%" disabled/>
                                <x-jet-input-error for="vOil_des" class="mt-2" />        
                            </div>  
                        </div>
                        <div class="form-group col-span-6 sm:col-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="mx-2">           
                                <x-jet-label for="vAgua" value="{{ __('Vol. Agua (mt3):') }}" />
                                <x-jet-input id="vAgua" type="number"   class="mt-1 block w-full form-control shadow-none" wire:model.defer="vAgua" style="width: 100%" disabled/>
                                <x-jet-input-error for="vAgua" class="mt-2" />        
                            </div>  
                            <div class="mx-2">           
                                <x-jet-label for="vTotal" value="{{ __('Vol. Total (mt3):') }}" />
                                <x-jet-input id="vTotal" type="number" class="mt-1 block w-full form-control shadow-none" wire:model.defer="vTotal" style="width: 100%" disabled/>
                                <x-jet-input-error for="vTotal" class="mt-2" />        
                            </div>  
                            <div class="mx-2">           
                                <x-jet-label for="vTotal" value="{{ __('Presione para recalcular') }}" />
                                <button wire:click='Recalcular' class="btn btn-danger"><i class="fa fa-16px fa-refresh"></i>&nbspRecalcular</i></button>       
                            </div>  

                        </div>
            
                    </div>
                    <div class="card-footer">
                        <button wire:click="$emit('updateDetalle',{{$edit_id}})" class="btn btn-primary">Actualizar</button>
                        <button wire:click='showForm' class="btn btn-warning"><i class="fa fa-16px fa-arrow-left"></i>&nbsp&nbspVolver</i></button>
                    </div>
                
            </div>
        </div>
    </div>
    @endif

    @push('js')
        <script>    
           Livewire.on('updateDetalle',oilDetailId=>{
                Swal.fire({
                    title: 'Está Seguro de Modificar Mediciones?',
                    text: "Los dias siguientes deberán ser recalculados!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Actualizar'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('oil-detail-create','update',oilDetailId);
                        Swal.fire(
                        'Actualizado!',
                        'Las producciones se han recalculado automaticamente.',
                        'success'
                        )
                    }
                })
           });
        </script>  
    @endpush
</div>




