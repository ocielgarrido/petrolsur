<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
 
    <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td{
        border: 1px solid #dddddd;
        text-align: left;
        font-size: 11px;
        padding: 8px;
        } 

        th {
        border: 1px solid #dddddd;
        text-align: left;
        font-size: 11px;
        padding: 8px;
        }

        tr {
            
        }
        
        thead{
            border: 2px solid #dddddd;
            background:#E5E7E9;

        }
        img {
            border-radius: 8px;
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="right">
        <img src="{{public_path('/img/petrolsur.png')}}"/>
    </div>

    <div class="center">   
        <p style="text-align: center; vertical-align: middle;font-size=20; font-family: arial, sans-serif; font-weight: bold;"> PARTE DIARIO PRODUCCION {{$fecha}}</p>
    </div>

    <div>
        {{-- Tabla produccion --}}
        <table style="width: 100%">
            <thead >
                <tr>
                    <th colspan="10" class="text-center">Producción</th>
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
                    <th colspan="3" style="text-align: center;">Incrementos / Mermas</th>
                </tr>
                <tr>
                    <th>Yacimiento</th>
                    <th>Mt3.</th>
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
                -               
                @endforelse
            </tbody>
        </table>

        {{--  paros pozo --}}
        <br>
        <hr>
        <table style="width: 100%">
            <thead >
                    <tr>
                        <th colspan="6" style="text-align: center;">Paros de Pozo</th>
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
                -
                @endforelse                                                          
            </tbody>
        </table>

        {{--  controles pozo --}}
        <br>
        <hr>
        <table style="width: 100%">
            <thead >
                <tr>
                    <th colspan="10" style="text-align: center;">Controles de Pozo</th>
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
                - 
                @endforelse                                                          
          </tbody>
        </table>

        {{-- intervenciones --}}
        <br>
        <hr>
        <table style="width: 100%">
            <thead >
                <tr>
                    <th colspan="4" style="text-align: center;">Intervenciones</th>
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
                -  
                @endforelse                                                          
            </tbody>
        </table>

        <br>
        <hr>
        {{-- Paros Compresor --}}
        <table style="width: 100%">
            <thead >
                <tr>
                    <th colspan="4" style="text-align: center;">Paros Moto Compresor</th>
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
                -
                @endforelse                                                          
             </tbody>
        </table>                                
        <br>
        <hr>

        {{-- Novedades --}}
        <table style="width: 100%">
            <thead >
                <tr>
                    <th colspan="2" style="text-align: center;"">Novedades</th>
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
                -
               @endforelse                                                          
             </tbody> 
        </table>

    </div>
</body>
</html>