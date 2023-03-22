<div>
    <x-data-table :data="$data" :model="$clients">
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
                <th><a wire:click.prevent="sortBy('cuit')" role="button" href="#">
                    Cuit.
                    @include('components.sort-icon', ['field' => 'cuit'])
                </a></th>
                <th><a wire:click.prevent="sortBy('telefono')" role="button" href="#">
                    Teléfono
                    @include('components.sort-icon', ['field' => 'telefono'])
                </a></th>
                <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                    Correo.
                    @include('components.sort-icon', ['field' => 'email'])
                </a></th>
                <th><a wire:click.prevent="sortBy('direccion')" role="button" href="#">
                    Dirección.
                    @include('components.sort-icon', ['field' => 'direccion'])
                </a></th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($clients as $client)
                <tr x-data="window.__controller.dataTableController({{ $client->id }})">
                   <td>{{ $client->id }}</td>
                    <td>{{ $client->nombre }}</td>
                    <td>{{ $client->cuit }}</td>
                    <td>{{ $client->telefono}}</td>
                    <td>{{ $client->email}}</td>
                    <td>{{ $client->direccion}}</td>
                     <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/client/edit/{{ $client->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
