<div>
    <x-data-table :data="$data" :model="$wellvariations">
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
                <th><a wire:click.prevent="sortBy('mt3')" role="button" href="#">
                    Mt3.
                    @include('components.sort-icon', ['field' => 'mt3'])
                </a></th>              
                <th><a wire:click.prevent="sortBy('obs')" role="button" href="#">
                    Obs.
                    @include('components.sort-icon', ['field' => 'obs'])
                </a></th>              
                <th><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Esatdo.
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>              
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($wellvariations as $wellvariation)
                <tr x-data="window.__controller.dataTableController({{ $wellvariation->id }})">
                   <td>{{ $wellvariation->id }}</td>
                    <td>{{ $wellvariation->fecha->format('d-m-Y') }}</td>
                    <td>{{ $wellvariation->mt3 }}</td>
                    <td>{{ $wellvariation->obs }}</td>
                    <td>{{ $wellvariation->estado }}</td>
                     <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $wellvariation->estado!='Cerrado' ) 
                            <a role="button" href="/variation/edit/{{ $wellvariation->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif    
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
