<div>
    <x-data-table :data="$data" :model="$gasses">
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
                <th><a wire:click.prevent="sortBy('pm10')" role="button" href="#">
                    PM10
                    @include('components.sort-icon', ['field' => 'pm10'])
                </a></th>
                <th><a wire:click.prevent="sortBy('p316')" role="button" href="#">
                    PM316
                    @include('components.sort-icon', ['field' => 'pm316'])
                </a></th>
                <th><a wire:click.prevent="sortBy('a9300')" role="button" href="#">
                    a 9300
                    @include('components.sort-icon', ['field' => 'a9300'])
                </a></th>
                <th><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($gasses as $gasse)
                <tr x-data="window.__controller.dataTableController({{ $gasse->id }})">
                    <td>{{ $gasse->id }}</td>
                    <td>{{ $gasse->fecha->format('d-m-Y') }}</td>      
                     <td>{{ $gasse->pm10 }}</td>
                     <td>{{ $gasse->pm316 }}</td>
                     <td>{{ $gasse->a9300 }}</td>
                     <td>{{ $gasse->estado }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $gasse->estado!='Cerrado' ) 
                            <a role="button" href="/gasse/edit/{{ $gasse->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif    
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>

