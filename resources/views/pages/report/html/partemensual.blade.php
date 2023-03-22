<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parte Mensual</title>
 
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
        <p style="text-align: center; vertical-align: middle;font-size=20; font-family: arial, sans-serif; font-weight: bold;"> PRODUCCION {{$datosprod['area']}}</p>
    </div>
    <div class="center">   
        <p style="text-align: center; vertical-align: middle;font-size=20; font-family: arial, sans-serif; font-weight: bold;"> DESDE: {{$datosprod['desde']}} HASTA: {{$datosprod['hasta']}} </p>
    </div>

    <div>
        {{-- Tabla produccion --}}
        <table border="1" style="width: 50%">
            <thead >
                <tr>
                    <th colspan="3" style="text-align: center; color:blue">DATOS OBTENIDOS</th>
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
                    <td>Ventas Gas </td>
                    <td class="text-right">{{floatval($datosprod['prod_gas'])}} </td>
                    <td class="text-right">{{floatval($datosprod['prod_gasDia'])}} </td>
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
</body>
</html>