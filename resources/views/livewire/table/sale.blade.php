<div>
    <x-data-table :data="$data" :model="$sales">
        <x-slot name="head">
            <tr>
                 <th class="text-nowrap"><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>            
                <th class="text-nowrap"><a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('remito')" role="button" href="#">
                    Remito
                    @include('components.sort-icon', ['field' => 'remito'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('tank_id')" role="button" href="#">
                    Tanque
                    @include('components.sort-icon', ['field' => 'tank_id'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('product_id')" role="button" href="#">
                    Producto
                    @include('components.sort-icon', ['field' => 'product_id'])
                </a></th>
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('total')" role="button" href="#">
                    Vendido H (mt3).
                    @include('components.sort-icon', ['field' => 'total'])
                    </a>
                </th>             
                <th class="text-nowrap">
                    <a wire:click.prevent="sortBy('total_des')" role="button" href="#">
                    Vendido D (mt3).
                    @include('components.sort-icon', ['field' => 'total_des'])
                    </a>
                </th>             
                <th class="text-nowrap"><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>             
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($sales as $sale)
                <tr x-data="window.__controller.dataTableController({{ $sale->id }})">
                    <td>{{ $sale->id }}</td>
                    <td class="text-nowrap">{{ $sale->fecha->format('d-m-Y') }}</td>
                    <td class="text-nowrap">{{ $sale->remito}}</td>
                    <td class="text-nowrap">{{ $sale->tank->nombre }}</td>             
                    <td class="text-nowrap">{{ $sale->product->nombre}}</td>
                    <td class="text-nowrap">{{ $sale->total}}</td>
                    <td class="text-nowrap">{{ $sale->total_des}}</td>
                    <td class="text-nowrap">{{ $sale->estado}}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $sale->estado!='Cerrado' ) 
                            <a role="button" href="/sale/edit/{{ $sale->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
