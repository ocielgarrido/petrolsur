<div>
    <x-data-table :data="$data" :model="$wells">
        <x-slot name="head">
            <tr>
            
               <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                    <th><a wire:click.prevent="sortBy('pozo')" role="button" href="#">
                    Pozo
                    @include('components.sort-icon', ['field' => 'pozo'])
                </a></th>
                <th><a wire:click.prevent="sortBy('well_formation_id')" role="button" href="#">
                    Formación.
                    @include('components.sort-icon', ['field' => 'well_formation->nombre'])
                </a></th>
                <th><a wire:click.prevent="sortBy('api')" role="button" href="#">
                    Nombre Cap. IV
                    @include('components.sort-icon', ['field' => 'cap_iv_nombre'])
                </a></th>
                <th><a wire:click.prevent="sortBy('cord_x')" role="button" href="#">
                    Coord. X.
                    @include('components.sort-icon', ['field' => 'cord_x'])
                </a></th>
                <th><a wire:click.prevent="sortBy('cord_y')" role="button" href="#">
                    Coord. Y.
                    @include('components.sort-icon', ['field' => 'cord_x'])
                </a></th>
                <th><a wire:click.prevent="sortBy('profundidad')" role="button" href="#">
                    Profundidad.
                    @include('components.sort-icon', ['field' => 'profundidad'])
                </a></th>
                <th><a wire:click.prevent="sortBy('well_state_id')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'well_state_id'])
                </a></th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($wells as $well)
                <tr x-data="window.__controller.dataTableController({{ $well->id }})">
                    <td>{{ $well->id }}</td>
                    <td scope="col" style="white-space: nowrap !important;">{{ $well->pozo }}</td>
                    <td scope="col" style="white-space: nowrap !important;">{{ $well->well_formation->nombre}}</td>
                    <td scope="col" style="white-space: nowrap !important;">{{ $well->cap_iv_nombre}}</td>
                    <td>{{ $well->cord_x}}</td>
                    <td>{{ $well->cord_y}}</td>
                    <td>{{ $well->profundidad}}</td>
                    <td scope="col" style="white-space: nowrap !important;">{{ $well->well_state->codigo}}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/well/edit/{{ $well->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
