<div>
    <x-data-table :data="$data" :model="$roles">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                    Name
                    @include('components.sort-icon', ['field' => 'name'])
                </a></th>           
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                    Creado
                    @include('components.sort-icon', ['field' => 'created_at'])
                </a></th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($roles as $rol)
                <tr x-data="window.__controller.dataTableController({{ $user->id }})">
                    <td>{{ $rol->id }}</td>
                    <td>{{ $rol->name }}</td>
                     <td>{{ $rol->created_at->format('d m Y H:i') }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/role/edit/{{ $rol->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
