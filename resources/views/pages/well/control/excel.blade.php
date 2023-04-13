
<table>
    <thead>
    <tr><td colspan="11" style="text-align: center;font-size: 14px;font-weight: bold">CONTROLES DE POZO</td></tr>    
    <tr>
        <th style="text-align: center;font-size: 10px;font-weight: bold" >ID Pozo</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Pozo</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold" >N. Cap.IV</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Pet</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Fecha</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Bruta M3</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">% Agua</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Oil Neto</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Agua Neta</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Gas Neto</th>
        <th style="text-align: center;font-size: 10px;font-weight: bold">Prod. Bruta</th>

    </tr>
    </thead>
    <tbody>
    @foreach($controles as $c)
    @php 
      $NuevaFecha = date('d/m/Y', strtotime($c->fecha));
    @endphp 
        <tr>
            <td>{{ $c->idpozo }}</td>
            <td>{{ $c->pozo }}</td>
            <td>{{ $c->cap_iv_nombre }}</td>
            <td>{{ $c->pet }}</td>
            <td>{{ $NuevaFecha}}</td>
            <td>{{ $c->prod_bruta_mt3 }}</td>
            <td>{{ $c->agua_emul_por }}</td>
            <td>{{ $c->oil_neto_mt3 }}</td>
            <td>{{ $c->agua_neto_24 }}</td>
            <td>{{ $c->gas_neto_mt3 }}</td>
            <td>{{ $c->prod_bruta_24 }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
