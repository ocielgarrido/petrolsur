<div>
    <x-data-table :data="$data" :model="$wellinterventions">
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
                <th><a wire:click.prevent="sortBy('well_id')" role="button" href="#">
                    Pozo.
                    @include('components.sort-icon', ['field' => 'well_id'])
                </a></th>              
                <th><a wire:click.prevent="sortBy('obs')" role="button" href="#">
                    Motivo.
                    @include('components.sort-icon', ['field' => 'Motivo'])
                </a></th>              
                <th><a wire:click.prevent="sortBy('obs')" role="button" href="#">
                    Obs.
                    @include('components.sort-icon', ['field' => 'obs'])
                </a></th>              
                <th><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>              
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($wellinterventions as $wellintervention)
                <tr x-data="window.__controller.dataTableController({{ $wellintervention->id }})">
                   <td>{{ $wellintervention->id }}</td>
                   <td scope="col" style="white-space: nowrap !important;">{{ $wellintervention->fecha->format('d-m-Y') }}</td>
                    <td scope="col" style="white-space: nowrap !important;">{{ $wellintervention->well->pozo}}</td>
                    <td>{{ $wellintervention->motivo }}</td>
                    <td>{{ $wellintervention->obs }}</td>
                    <td>{{ $wellintervention->estado }}</td>                    
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $post->estado!='Cerrado' ) 
                            <a role="button" href="/wellintervention/edit/{{ $wellintervention->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif    
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
