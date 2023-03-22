<div>
    <x-data-table :data="$data" :model="$tanks">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
           
                <th><a wire:click.prevent="sortBy('nombre')" role="button" href="#">
                    Nombre
                    @include('components.sort-icon', ['field' => 'nombre'])
                </a></th>
                <th><a wire:click.prevent="sortBy('capacidad')" role="button" href="#">
                    Cap.
                    @include('components.sort-icon', ['field' => 'capacidad'])
                </a></th>
                <th><a wire:click.prevent="sortBy('api')" role="button" href="#">
                    Api
                    @include('components.sort-icon', ['field' => 'api'])
                </a></th>
                <th><a wire:click.prevent="sortBy('cte')" role="button" href="#">
                    Cte.
                    @include('components.sort-icon', ['field' => 'cte'])
                </a></th>
                <th><a wire:click.prevent="sortBy('largo')" role="button" href="#">
                    Largo.
                    @include('components.sort-icon', ['field' => 'largo'])
                </a></th>
                <th><a wire:click.prevent="sortBy('altura')" role="button" href="#">
                    Alto.
                    @include('components.sort-icon', ['field' => 'altura'])
                </a></th>
                <th><a wire:click.prevent="sortBy('altura')" role="button" href="#">
                    Altura total.
                    @include('components.sort-icon', ['field' => 'alturaT'])
                </a></th>
                <th><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($tanks as $tank)
                <tr x-data="window.__controller.dataTableController({{ $tank->id }})">
                    <td>{{ $tank->id }}</td>
                    <td>{{ $tank->nombre }}</td>
                    <td>{{ $tank->capacidad }}</td>
                    <td>{{ $tank->api==1 ? 'Si' : 'No'}}</td>
                    <td>{{ $tank->cte}}</td>
                    <td>{{ $tank->largo}}</td>
                    <td>{{ $tank->altura}}</td>
                    <td>{{ $tank->alturaT}}</td>
                    <td>{{ $tank->estado}}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/tank/edit/{{ $tank->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
