<div>
    <x-data-table :data="$data" :model="$permissions">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                    Nombre permiso
                    @include('components.sort-icon', ['field' => 'name'])
                </a></th>
                <th><a wire:click.prevent="sortBy('guard_name')" role="button" href="#">
                    Guard
                    @include('components.sort-icon', ['field' => 'guard_name'])
                </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                    Creado
                    @include('components.sort-icon', ['field' => 'created_at'])
                </a></th>
                 <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($permissions as $permission)
                <tr x-data="window.__controller.dataTableController({{ $permission->id }})">
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>
                    <td>{{ $permission->created_at->format('d M Y H:i') }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/permission/edit/{{ $permission->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
