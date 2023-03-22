<div>
    <x-data-table :data="$data" :model="$sales">
        <x-slot name="head">
            <tr>
                 <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>            
                <th><a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                </a></th>
                <th><a wire:click.prevent="sortBy('remito')" role="button" href="#">
                    Remito
                    @include('components.sort-icon', ['field' => 'remito'])
                </a></th>
                <th><a wire:click.prevent="sortBy('tank_id')" role="button" href="#">
                    Tanque
                    @include('components.sort-icon', ['field' => 'tank_id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('product_id')" role="button" href="#">
                    Producto
                    @include('components.sort-icon', ['field' => 'product_id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('total')" role="button" href="#">
                    Mt3.
                    @include('components.sort-icon', ['field' => 'total'])
                </a></th>             
                <th><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>             
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($sales as $sale)
                <tr x-data="window.__controller.dataTableController({{ $sale->id }})">
                    <td class="text-center">{{ $sale->id }}</td>
                    <td class="text-center">{{ $sale->fecha->format('d-m-Y') }}</td>
                    <td class="text-right">{{ $sale->remito}}</td>
                    <td class="text-right">{{ $sale->tank->nombre }}</td>             
                    <td class="text-right">{{ $sale->product->nombre}}</td>
                    <td class="text-right">{{ number_format($sale->total,2)}}</td>
                    <td class="text-right">{{ $sale->estado}}</td>
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
