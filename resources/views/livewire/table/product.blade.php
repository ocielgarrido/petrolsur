<div>
    <x-data-table :data="$data" :model="$products">
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
                <th><a wire:click.prevent="sortBy('production')" role="button" href="#">
                    Afecta Producción.
                    @include('components.sort-icon', ['field' => 'production'])
                </a></th>              
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($products as $product)
                <tr x-data="window.__controller.dataTableController({{ $product->id }})">
                   <td>{{ $product->id }}</td>
                    <td>{{ $product->nombre }}</td>
                    <td>{{ $product->production }}</td>
                     <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/product/edit/{{ $product->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                   </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
