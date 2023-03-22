<div>
    <x-data-table :data="$data" :model="$movements">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a>
                </th>
                <th><a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                </a>
                </th>           
                <th><a wire:click.prevent="sortBy('remito')" role="button" href="#">
                    Remito
                    @include('components.sort-icon', ['field' => 'remito'])
                </a>
                </th>           
                <th><a wire:click.prevent="sortBy('tipo')" role="button" href="#">
                    Tipo
                    @include('components.sort-icon', ['field' => 'tipo'])
                </a>
                </th>
                <th><a wire:click.prevent="sortBy('tipo')" role="button" href="#">
                    Mov
                    @include('components.sort-icon', ['field' => 'torigen'])
                </a>
                </th>
                <th><a wire:click.prevent="sortBy('proucto_id')" role="button" href="#">
                    Producto
                    @include('components.sort-icon', ['field' => 'proucto_id'])
                </a>
                </th>
                <th><a wire:click.prevent="sortBy('volumen')" role="button" href="#">
                    Volumen
                    @include('components.sort-icon', ['field' => 'volumen'])
                </a>
                </th> 
                <th><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado
                    @include('components.sort-icon', ['field' => 'estado'])
                </a>
                </th> 
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($movements as $movement)
                <tr x-data="window.__controller.dataTableController({{ $movement->id }})">
                    <td>{{ $movement->id }}</td>
                    <td class="text-nowrap text-center">{{ $movement->fecha->format('d-m-Y') }}</td>      
                    <td>{{ $movement->remito }}</td>                  
                    <td>{{$movement->tipo=='mov_int' ? 'Interno' : 'Externo' }}</td>
                   @if($movement->tipo=='mov_int')
                    <td class="text-nowrap text-center">{{ $movement->torigen}} -> {{ $movement->tdestino}} </td>
                   @else               
                   <td class="text-nowrap text-center"> {{ $movement->tdestino}} </td>                       
                   @endif 
                    <td>{{ $movement->product->nombre}}</td>                    
                    <td>{{ number_format($movement->volumen,2) }}</td>
                    <td>{{ $movement->estado }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $movement->estado!='Cerrado' )  
                            <a role="button" href="/movement/edit/{{ $movement->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif    
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>

