<div>
    <x-data-table :data="$data" :model="$oils">
        <x-slot name="head">
            <tr>
                <th>Acciones</th>
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                    </a>
                </th>            
                 <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                    </a class="text-nowrap">
                </th>            
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('stock_oil_h')" role="button" href="#">
                    S. Oil H.
                    @include('components.sort-icon', ['field' => 'stock_oil_h'])
                    </a class="text-nowrap">
                </th>
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('stock_oil_d')" role="button" href="#">
                    S. Oil D.
                    @include('components.sort-icon', ['field' => 'stock_oil_d'])
                    </a class="text-nowrap">
                </th>
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('stock_agua')" role="button" href="#">
                    S. Agua 
                    @include('components.sort-icon', ['field' => 'stock_agua'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('stock_total')" role="button" href="#">
                    S. Total
                    @include('components.sort-icon', ['field' => 'stock_total'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('prod_oil_h')" role="button" href="#">
                    P. Oil H. 
                    @include('components.sort-icon', ['field' => 'prod_oil_h'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('prod_oil_d')" role="button" href="#">
                    P. Oil D.
                    @include('components.sort-icon', ['field' => 'prod_oil_d'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('prod_oil_d')" role="button" href="#">
                    P. Agua
                    @include('components.sort-icon', ['field' => 'prod_oil_d'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('prod_oil_d')" role="button" href="#">
                    P. Bruta.
                    @include('components.sort-icon', ['field' => 'prod_oil_d'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('total_venta_h')" role="button" href="#">
                    T. Venta H.
                    @include('components.sort-icon', ['field' => 'total_venta_h'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('total_venta_d')" role="button" href="#">
                    T. Venta D.
                    @include('components.sort-icon', ['field' => 'total_venta_d'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('mov_int')" role="button" href="#">
                    M.I.
                    @include('components.sort-icon', ['field' => 'mov_int'])
                    </a>
                </th>              
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('mov_ext')" role="button" href="#">
                    M.E.
                    @include('components.sort-icon', ['field' => 'mov_ext'])
                    </a>
                </th>              
                <th class="text-nowrap"><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>              
             </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($oils as $oil)
                <tr x-data="window.__controller.dataTableController({{ $oil->id }})">
                    <td class="whitespace-no-wrap row-action--icon">                    
                        <a role="button" href="/oil/edit/{{$oil->id}}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500 mr-3"></i></a>
                        <a role="button" x-on:click.prevent="recalculaItem" href="#"><i class="fa fa-16px fa-refresh text-red-500 mr-3"></i></a>
                    </td>
                    <td>{{ $oil->id }}</td>
                    <td class="text-nowrap">{{ $oil->fecha->format('d-m-Y') }}</td>
                    <td class="text-nowrap">{{ $oil->stock_oil_h }}</td>
                    <td class="text-nowrap">{{ $oil->stock_oil_d }}</td>
                    <td class="text-nowrap">{{ $oil->stock_agua }}</td>
                    <td class="text-nowrap">{{ $oil->stock_total }}</td>
                    <td class="text-nowrap">{{ $oil->prod_oil_h }}</td>
                    <td class="text-nowrap">{{ $oil->prod_oil_d }}</td>
                    <td class="text-nowrap">{{ $oil->prod_agua }}</td>
                    <td class="text-nowrap">{{ $oil->prod_bruta }}</td>
                    <td class="text-nowrap">{{ $oil->total_venta_h }}</td>
                    <td class="text-nowrap">{{ $oil->total_venta_d }}</td>
                    <td class="text-nowrap">{{ $oil->mov_int }}</td>
                    <td class="text-nowrap">{{ $oil->mov_ext }}</td>
                    <td class="text-nowrap">{{ $oil->estado }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>

  
</div>

