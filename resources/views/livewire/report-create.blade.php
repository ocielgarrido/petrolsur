<div>
    @include('common.alerts');
    @include('common.messages');

    <x-slot name="header_content">
        <h3>Reportes</h3>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Rerportes</a></div>
            <div class="breadcrumb-item">Reporte</div>
        </div>
    </x-slot>
    <div class="grid grid-cols-6 md:grid-cols-12 gap-2">
        <div class="col-span-6 md:col-span-3 bg-white-800 p-4 border-2 border-blue-500 border-opacity-100">
            <div>  
                <div >
                    <br>
                    <hr style="width: 100%">
                    <h2 class="text-center">Reportes</h2>
                    <hr style="width: 100%">
                </div>    
                
                <div class="form-group col-span-6 sm:col-span-5">
                    <div class="mx-2">    
                        <x-jet-label for="report.area_id" value="{{ __('Area:') }}" />
                        <select class="form-select" wire.model.defer="area_id" style="width: 100%" required autofocus>
                            <option value="--">--Seleccione--</option>                        
                            <option value="1">CCO-NORTE</option>                                           
                        </select>
                        <x-jet-input-error for="report.area_id" class="mt-2" />   
                    </div>
                </div>   
                
                <div class="form-group col-span-6 sm:col-span-5">
                    <div class="mx-2">    
                        <x-jet-label for="report.reportId" value="{{ __('Reporte:') }}" />
                        <select class="form-select" wire:model.defer="report.reportId" style="width: 100%"  onchange="getval(this);" required  >
                            <option value="--">--Seleccione--</option>
                            @foreach($reports as $reports)
                            <option value="{{$reports->id}}">{{$reports->titulo}}</option>   
                            @endforeach                                   
                        </select>
                        <x-jet-input-error for="report.reportId" class="mt-2" />   
                    </div>
                </div>  
               
                <div class="form-group col-span-6 sm:col-span-5"  id="fechaFrom">
                    <div class="mx-2"> 
                        <x-jet-label for="report.fechafrom" value="{{ __('Desde') }}" />
                        <input type="text" id="inputfechaFrom" class="form-control flatpickr" data-toggle="date" wire:model.defer="report.fechaFrom" onchange="setValDatePicker(this);" placeholder="Seleccione fecha" required>
                        <x-jet-input-error for="report.fechaFrom" class="mt-2" />
                    </div>  
                </div>   

                <div class="form-group col-span-6 sm:col-span-5" id="fechaTo" hidden >
                    <div class="mx-2"> 
                        <x-jet-label for="report.fechato" value="{{ __('Hasta') }}" />
                        <input type="text" id="inputfechaTo" class="form-control flatpickr" data-toggle="date" wire:model.defer="report.fechaTo"  placeholder="Seleccione fecha" required >
                        <x-jet-input-error for="report.fechaTo" class="mt-2" />
                    </div> 
                </div> 
                <div class="form-group col-span-6 sm:col-span-5" id="wells" hidden >
                    <div class="mx-2"> 
                        <x-jet-label for="report.well_id" value="{{ __('Pozo') }}" />
                        <select class="form-select" wire:model.defer="report.well_id" style="width: 100%"   >
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
                        <button wire:click='ViewReport()' class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"  ><i class="fa fa-magnifying-glass"></i>&nbsp&nbspVisualizar</button>
                    </div> 
                </div>          
            
            </div>
             
        </div>
        <div class="col-span-6 md:col-span-9 bg-white-500 p-4 border-2 border-blue-500 border-opacity-100">
            <div >
                <br>
                <hr style="width: 100%">
                <h2 class="text-center">Vista Previa</h2>
                <hr style="width: 100%">
            </div>  
            <div >
                @php
                $report= $report->reportId;
                $area=$area_id;                
                @endphp
                @switch($report)
                    @case(1)
                    
                        <div>
                                {{-- Tabla produccion --}}
                                @php
                                  //  dd($datosprod);
                                @endphp
                                @if($datosprod===0)
                                    <table>
                                        <tr>
                                            <th  style="text-align: center; color:red">No Se encontraron datos para fecha seleccionada</th>
                                        </tr> 
                                    </table>
                                @else
                                    <table style="width: 100%">
                                        <thead >
                                            <tr>
                                                <th colspan="10" style="text-align: center; color:blue">Producción</th>
                                            </tr>    
                                            <tr>
                                                <th class="text-left">Yac.</th>
                                                <th class="text-center">P.Bruta</th>
                                                <th class="text-center">P.Neta</th>
                                                <th class="text-center">Stock. Oil H.</th>
                                                <th class="text-center">Stock. Agua</th>
                                                <th class="text-center">Venta de Gas</th>
                                                <th class="text-center">Stock. Oil D.</th>
                                                <th class="text-center">Venta</th>
                                                <th class="text-center">M.Int</th>
                                                <th class="text-center">M.ext</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                            <tr>
                                                <td class="text-left">{{$area}}</td>
                                                <td class="text-center">{{floatval($datosprod['prod_bruta_dia'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['prod_neta_dia'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['oil_dia'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['agua_dia'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['gas_dia'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['oil_des_dia'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['ventas_dia'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['movint'])}}</td>
                                                <td class="text-center">{{floatval($datosprod['movext'])}}</td>
                                            <tr>                                                
                                        </tbody> 
                                    </table>
                                                                   {{-- incrementos Mermas produccion --}}
                                <br>
                                <hr>
                                <table style="width: 100%">
                                    <thead >
                                        <tr>
                                            <th colspan="3" style="text-align: center; color:blue">Incrementos / Mermas</th>
                                        </tr>
                                        <tr>
                                            <th>Yacimiento</th>
                                            <th>Mt. 3</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>            
                                        @forelse($dataWellVariations as $dataWellVariation)
                                            <tr>
                                                <td>{{$area}}</td>
                                                <td>{{$dataWellVariation->mt3}}</td>
                                                <td>{{$dataWellVariation->obs}}</td>
                                            <tr>   
                                        @empty    
                                        <tr>
                                            <td colspan="3" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                        <tr>  
                                        @endforelse
                                    </tbody>
                                </table>

                                {{--  paros pozo --}}
                                <br>
                                <hr>
                                <table style="width: 100%">
                                    <thead >
                                            <tr>
                                                <th colspan="6" style="text-align: center; color:blue">Paros de Pozo</th>
                                            </tr>
                                            <tr>
                                                <th>Yacimiento</th>
                                                <th>Pozo</th>
                                                <th>Horas</th>
                                                <th>Oil</th>
                                                <th>Gas</th>
                                                <th>Motivo Paro</th>
                                            </tr>
                                    </thead>
                                    <tbody>     
                                        @forelse($dataWellDownTimes as $dataWellDownTime)                                       
                                            <tr>
                                                <td>{{$area}}</td>
                                                <td>{{$dataWellDownTime->well->pozo}}</td>
                                                <td>{{$dataWellDownTime->horas}}</td>
                                                <td>{{$dataWellDownTime->oil_perdido_mt3}}</td>
                                                <td>{{$dataWellDownTime->gas_perdido_mt3}}</td>
                                                <td>{{$dataWellDownTime->wellcause->causa}}</td>
                                            <tr>   
                                        @empty    
                                            <tr>
                                               <td colspan="6" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                            <tr>  
                                        @endforelse                                                          
                                    </tbody>
                                </table>
                                {{--  controles pozo --}}
                                <br>
                                <hr>
                                <table style="width: 100%">
                                    <thead >
                                        <tr>
                                            <th colspan="10" style="text-align: center; color:blue">Controles de Pozo</th>
                                        </tr>
                                        <tr>
                                            <th>Yacimiento</th>
                                            <th>Pozo</th>
                                            <th>Bruta</th>
                                            <th>% Agua</th>
                                            <th>Oil</th>
                                            <th>Agua</th>
                                            <th>Carrera</th>
                                            <th>GPM</th>
                                            <th>Gas</th>
                                            <th>Orificio</th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                                        @forelse($dataWellControls as $dataWellControl)                                           
                                            <tr>
                                                <td>{{$area}}</td>
                                                <td>{{$dataWellControl->well->pozo}}</td>
                                                <td>{{$dataWellControl->prod_bruta_mt3}}</td>
                                                <td>{{$dataWellControl->agua_emul_por}}</td>
                                                <td>{{$dataWellControl->oil_neto_mt3}}</td>
                                                <td>{{$dataWellControl->agua_neto_mt3}}</td>
                                                <td>{{$dataWellControl->carrera}}</td>
                                                <td>{{$dataWellControl->gpm}}</td>
                                                <td>{{$dataWellControl->gas_neto_mt3}}</td>
                                                <td>{{$dataWellControl->orificio}}</td>
                                            <tr>                                        
                                        @empty    
                                            <tr>
                                               <td colspan="10" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                            <tr>  
                                        @endforelse                                                          
                                  </tbody>
                                </table>

                                {{-- intervenciones --}}
                                <br>
                                <hr>
                                <table style="width: 100%">
                                    <thead >
                                        <tr>
                                            <th colspan="4" style="text-align: center; color:blue">Intervenciones</th>
                                        </tr>
                                        <tr>
                                            <th>Yacimiento</th>
                                            <th>Pozo</th>
                                            <th>Motivo</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                            
                                        @forelse($dataWellInterventions as $dataWellIntervention)                                           
                                           <tr>
                                                <td>{{$area}}</td>
                                                <td>{{$dataWellIntervention->well->pozo}}</td>
                                                <td>{{$dataWellIntervention->motivo}}</td>
                                                <td>{{$dataWellIntervention->obs}}</td>
                                            <tr>                                        
                                        @empty    
                                            <tr>
                                                <td colspan="5" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                            <tr>  
                                        @endforelse                                                          
                                    </tbody>
                                </table>

                                <br>
                                <hr>
                                {{-- Paros Compresor --}}
                                <table style="width: 100%">
                                    <thead >
                                        <tr>
                                            <th colspan="4" style="text-align: center; color:blue">Paros Moto Compresor</th>
                                        </tr>
                                        <tr>
                                            <th>Yacimiento</th>
                                            <th>Horas</th>
                                            <th>Mt.3</th>
                                            <th>Motivo</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                  
                                        @forelse($dataCompressorDownTimes as $dataCompressorDownTime)                                           
                                           <tr>
                                                <td>{{$area}}</td>
                                                <td>{{$dataCompressorDownTime->horas}}</td>
                                                <td>{{$dataCompressorDownTime->horas_paro_msa}}</td>
                                                <td>{{$dataCompressorDownTime->compressor_causes_id}}</td>
                                            <tr>                                        
                                        @empty    
                                            <tr>
                                                <td colspan="4" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                            <tr>  
                                        @endforelse                                                          
                                     </tbody>
                                </table>                                
                                <br>
                                <hr>

                                {{-- Novedades --}}
                                <table style="width: 100%">
                                    <thead >
                                        <tr>
                                            <th colspan="2" style="text-align: center; color:blue">Novedades</th>
                                        </tr>
                                        <tr>
                                            <th>Yacimiento</th>
                                            <th>Novedades</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        @forelse($dataNovedades as $dataNovedade)                                           
                                           <tr>
                                                <td>{{$area}}</td>
                                                <td>{{$dataNovedade->obs}}</td>
                                            <tr>                                        
                                        @empty    
                                            <tr>
                                                <td colspan="2" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                            <tr>  
                                        @endforelse                                                          
                                     </tbody> 
                                </table>
 
                                @endif

 
                        </div>
                        @break

                    @case(2)
                    <div>
                        {{-- Tabla produccion --}}
                        <table border="1" style="width: 50%">
                            <thead >
                                <tr>
                                    <th colspan="3" style="text-align: center; color:blue">PRODUCCION {{$datosprod['area']}}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" style="text-align: center; color:blue">DESDE: {{$datosprod['desde']}} HASTA: {{$datosprod['hasta']}} </th>
                                </tr>
                            </thead>
                            <tbody>    
                                <tr>
                                    <th>Descripcion</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Promedio</th>
                                </tr>
                                <tr>
                                    <td >Producción Bruta: </td>
                                    <td class="text-right">{{floatval($datosprod['prod_bruta'])}}</td>
                                    <td class="text-right">{{floatval($datosprod['prod_brutaDia'])}}</td>
                                </tr>
                                <tr>
                                    <td>Oil Hidratado </td>
                                    <td class="text-right">{{floatval($datosprod['prod_oil'])}} </td>
                                    <td class="text-right">{{floatval($datosprod['prod_oilDia'])}} </td>
                                </tr>
                                <tr>
                                    <td>Oil Deshidratado</td>
                                    <td class="text-right">{{floatval($datosprod['prod_oilD'])}} </td>
                                    <td class="text-right">{{floatval($datosprod['prod_oilDDia'])}} </td>
                                </tr>
                                <tr>
                                    <td>Ventas Gas a9300 </td>
                                    <td class="text-right">{{floatval($datosprod['prod_gas'])}} </td>
                                    <td class="text-right">{{floatval($datosprod['prod_gasDia'])}} </td>
                                </tr>
                                <tr>
                                    <td>Ventas Gas pm316 </td>
                                    <td class="text-right">{{floatval($datosprod['prod_gas316'])}} </td>
                                    <td class="text-right">{{floatval($datosprod['prod_gas316Dia'])}} </td>
                                </tr>
                                <tr>
                                    <td>Agua</td>
                                    <td class="text-right">{{floatval($datosprod['prod_agua'])}} </td>
                                    <td class="text-right">{{floatval($datosprod['prod_aguaDia'])}} </td>
                                </tr>
                                <tr>
                                    <td>Ventas Oil </td>
                                    <td class="text-right">{{floatval($datosprod['ventas'])}} </td>
                                    <td class="text-right">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Gasolina </td>
                                    <td class="text-right">{{floatval($datosprod['gasolina'])}} </td>
                                    <td class="text-right">&nbsp;</td>
                                </tr>
                            </tbody>    
                        </table>                          
                 
                    </div>

                        @break
                    @case(3)
                        <div>
                            <table style="width: 100%; border: 1px solid black;">
                                <thead >
                                    <tr>
                                        <th colspan="5" style="text-align: center; color:blue">CONTROLES DE POZO {{$area_id}}</th>
                                    </tr>    
                                    <tr>
                                        <th>Pozo</th>
                                        <th>Formación</th>
                                        <th>Fecha</th>
                                        <th>Horas</th>
                                        <th>Bruto Mt3</th>
                                        <th>% Agua</th>
                                        <th>Neto Mt3</th>
                                        <th>Gas x Control SM3</th>
                                        <th>Gas Inyectad0 SM3</th>
                                        <th>GOR</th>
                                    </tr>
                                </thead>
                                <tbody>                                    
                                    @forelse($dataWells as $dataWell)
                                    <tr>
                                        <td>{{$dataWell->well->pozo}}</td>
                                        <td>{{$dataWell->well->well_formation->nombre}}</td>
                                        <td>{{$dataWell->fecha->format('d-m-Y')}}</td>
                                        <td>{{$dataWell->horas}}</td>
                                        <td>{{$dataWell->prod_bruta_mt3}}</td>
                                        <td>{{$dataWell->agua_emul_por}}</td>
                                        <td>{{$dataWell->oil_neto_mt3}}</td>
                                        <td>{{$dataWell->gas_neto_24}}</td>
                                        <td>{{$dataWell->gas_inyectado}}</td>
                                        <td>{{$dataWell->gor}}</td>
                                    <tr>   
                                    @empty    
                                    <tr>
                                        <td colspan="10" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                    <tr>  
                                     @endforelse
                                </tbody> 
                            </table>
                      
                        </div>
                        @break
                    @case(4)
                        <div>
                        <table style="width: 100%; border: 1px solid black;">
                                <thead >
                                    <tr style=" border-bottom: solid 1px #df7e37;">
                                        <th colspan="9" style="text-align: center; color:blue"> ULTIMOS CONTROLES DE POZO {{$area_id}}</th>
                                    </tr>    
                                    <tr style=" border-bottom: solid 1px #df7e37;">
                                        <th style=" border-right: solid 1px #df7e37;">Pozo</th>
                                        <th style=" border-right: solid 1px #df7e37;" >Formación</th>
                                        <th style=" border-right: solid 1px #df7e37;">Fecha</th>
                                        <th style=" border-right: solid 1px #df7e37">Horas</th>
                                        <th style=" border-right: solid 1px #df7e37">Bruto Mt3</th>
                                        <th style=" border-right: solid 1px #df7e37">% Agua</th>
                                        <th style=" border-right: solid 1px #df7e37">Neto Mt3</th>
                                        <th style=" border-right: solid 1px #df7e37">Gas x Control SM3</th>
                                        <th style=" border-right: solid 1px #df7e37">Gas Inyectad0 SM3</th>
                                     </tr>
                                </thead>
                                <tbody>
                                        
                                    @forelse($dataWells as $dataWell)
                                    <tr>
                                    <td class="text-left" style=" border-right: solid 1px #df7e37;">{{$dataWell->well->pozo}}</td>
                                        <td class="text-left" style=" border-right: solid 1px #df7e37;">{{$dataWell->well->well_formation->nombre}}</td>
                                        <td class="text-center" style=" border-right: solid 1px #df7e37;">{{$dataWell->fecha->format('d-m-Y')}}</td>
                                        <td class="text-center" style=" border-right: solid 1px #df7e37;">{{$dataWell->horas}}</td>
                                        <td class="text-right" style=" border-right: solid 1px #df7e37;">{{$dataWell->prod_bruta_mt3}}</td>
                                        <td class="text-right" style=" border-right: solid 1px #df7e37;">{{$dataWell->agua_emul_por}}</td>
                                        <td class="text-right" style=" border-right: solid 1px #df7e37;">{{$dataWell->oil_neto_mt3}}</td>
                                        <td class="text-right" style=" border-right: solid 1px #df7e37;">{{$dataWell->gas_neto_24}}</td>
                                        <td class="text-right" style=" border-right: solid 1px #df7e37;">{{$dataWell->gas_inyectado}}</td>
                                     <tr>   
                                    @empty    
                                    <tr>
                                        <td colspan="9" style="text-align: center; color:red">NO SE ENCOTRARON DATOS</td>
                                    <tr>  
                                     @endforelse
                                </tbody> 
                                <tfoot> 
                                    <tr style=" border-top: solid 1px #df7e37;">
                                        <td colspan="4" class="text-right">Totales</td>                                       
                                        <td  class="text-right">{{floatval($datosprod['totalBruta'])}}</td>
                                        <td></td>
                                        <td class="text-right">{{floatval($datosprod['totalOIL'])}}</td>
                                        <td class="text-right">{{floatval($datosprod['totalGASSM'])}}</td>
                                        <td class="text-right">{{floatval($datosprod['totalGAS'])}}</td>
                                        <td class="text-right"></td>
                                      <tr>     
                                </tfoot> 
                            </table>
                      
                        </div>
                        @break

                    @default
  
                @endswitch
                <br><hr>
                <table style="width: 100%">
                    <thead >
                        <tr>
                            <th style="text-align: center; color:red">
                                <a  onclick="openUrl({{ $report}},'{{$fechaTo}}','{{$fechaFrom}}','{{$well_id}}');" class="btn btn-danger"  target="_blank">Confirmar/Ver</a>
                            </th>    
                        </tr>
                        
                    </thead>
                </table>

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
    <script>    
        function openUrl(rpTId, dTo, dFrom, well){
         if( rpTId=="1" || rpTId=="2"){   
            Swal.fire({
                title: 'Está Seguro de confirmar Parte',
                text: "Los datos quedarán cerrados",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si proceder'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Completado!',
                        'El parte ha sido cerrado.',
                        'success'
                    )
                    var url='report/'+rpTId + '/' + dTo + '/' + dFrom+ '/'+ 0;                       
                    window.open(url, "_blank");
                    window.location.href = 'report'; 
                }
            })
          }else if ( rpTId=="4" ){
             var url='report/4/0/0/0';   
             window.open(url, "_blank");
             window.location.href = 'report'; 
              
          }else{
            var url='report/'+rpTId + '/' + dTo + '/' + dFrom + '/' + well;   
             window.open(url, "_blank");
             window.location.href = 'report'; 

          }
        }
    
    </script>  
    <script>
        function getval(sel){           
            switch(sel.value) {
                case "1":
                    $("#fechaTo").hide();
                    $("#wells").hide();
                    $("#inputfechaTo").removeAttr("read-only");  
                    break;

                case "2":
                    $("#fechaTo").removeAttr("hidden");  
                    $("#fechaFrom").removeAttr("hidden");  
                    $("#inputfechaTo").removeAttr("read-only");  
                    $("#inputfechaFrom").removeAttr("read-only");  
                    $("#inputfechaTo").show();  
                    $("#inputfechaFrom").show();   
                    $("#fechaTo").show();
                    $("#fechaFrom").show();
                    $("#wells").hide();                    
                    break;

                case "3":
                    $("#fechaTo").removeAttr("hidden");  
                    $("#fechaFrom").removeAttr("hidden");  
                    $("#fechaTo").show();
                    $("#fechaFrom").show();
                    $("#inputfechaTo").removeAttr("read-only");  
                    $("#inputfechaFrom").removeAttr("read-only");  
                    $("#inputfechaTo").show();  
                    $("#inputfechaFrom").show();  
                    $("#wells").removeAttr("hidden");  
                    $("#wells").show();  
                    break;

                case "4":
                    $("#fechaTo").hide();  
                    $("#inputfechaTo").hide();  
                    $("#fechaFrom").hide();  
                    $("#inputfechaFrom").hide();  
                    $("#wells").hide(); 
                    break;
                default: alert(sel.value);
            }
        }

        function setValDatePicker(date){     
            $("#inputfechaTo").removeAttr("readonly");        
            $("#inputfechaTo").val(date.value);
        }
    </script>    
@endpush

