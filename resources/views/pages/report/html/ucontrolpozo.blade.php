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
        <p style="text-align: center; vertical-align: middle;font-size=20; font-family: arial, sans-serif; font-weight: bold;">ULTIMOS CONTROLES DE POZOS</p>
    </div>
 
    <div>
        <table style="width: 100%; border: 1px solid black;">
            <thead >
                <tr>
                    <th colspan="9" style="text-align: center; color:blue">ULTIMOS CONTROLES DE POZO {{$area}}</th>
                </tr>    
                <tr>
                    <th style="white-space:nowrap;">Pozo</th>
                    <th style="white-space:nowrap;">Formación</th>
                    <th style="white-space:nowrap;">Fecha</th>
                    <th style="text-align: center;">Horas</th>
                    <th style="text-align: right;">Bruto Mt3</th>
                    <th style="text-align: right;">% Agua</th>
                    <th style="text-align: right;">Neto Mt3</th>
                    <th style="text-align: right;">Gas x Control SM3</th>
                    <th style="text-align: right;">Gas Inyectad0 SM3</th>
                </tr>
            </thead>
            <tbody>                                    
                @forelse($dataWells as $dataWell)
                <tr>
                    <td style="white-space:nowrap;">{{$dataWell->well->pozo}}</td>
                    <td style="white-space:nowrap;">{{$dataWell->well->well_formation->nombre}}</td>
                    <td style="white-space:nowrap;">{{$dataWell->fecha->format('d-m-Y')}}</td>
                    <td style="text-align: right;">{{$dataWell->horas}}</td>
                    <td style="text-align: right;">{{$dataWell->prod_bruta_mt3}}</td>
                    <td style="text-align: right;">{{$dataWell->agua_emul_por}}</td>
                    <td style="text-align: right;">{{$dataWell->oil_neto_mt3}}</td>
                    <td style="text-align: right;">{{$dataWell->gas_neto_24}}</td>
                    <td style="text-align: right;">{{$dataWell->gas_inyectado}}</td>
                 <tr>   
                @empty    
                @endforelse
            </tbody> 
            <tfoot> 
                <tr style=" border-top: solid 1px #df7e37;">
                    <td colspan="4" class="text-right">Totales</td>                                       
                    <td  style="text-align: right;">{{floatval($datosprod['totalBruta'])}}</td>
                    <td></td>
                    <td style="text-align: right;">{{floatval($datosprod['totalOIL'])}}</td>
                    <td class="text-right">{{floatval($datosprod['totalGASSM'])}}</td>                                        
                    <td style="text-align: right;">{{floatval($datosprod['totalGAS'])}}</td>
                    <td style="text-align: right;"></td>
                 <tr>     
            </tfoot> 
        </table>

    </div>    
    </body>
    </html>