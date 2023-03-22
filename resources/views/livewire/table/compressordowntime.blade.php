<div>
    <x-data-table :data="$data" :model="$compresordowntimes">
        <x-slot name="head">
            <tr>
            
               <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('compressor_id')" role="button" href="#">
                    Compresor
                    @include('components.sort-icon', ['field' => 'compressor_id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('compressor_causes_id')" role="button" href="#">
                    Causa
                    @include('components.sort-icon', ['field' => 'compressor_causes_id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                </a></th>
                <th><a wire:click.prevent="sortBy('horas')" role="button" href="#">
                    Hs. paro
                    @include('components.sort-icon', ['field' => 'horas'])
                </a></th>
                <th><a wire:click.prevent="sortBy('horas_paro_msa')" role="button" href="#">
                    Mt3.
                    @include('components.sort-icon', ['field' => 'horas_paro_msa'])
                </a></th>
                <th><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'Estado'])
                </a></th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($compresordowntimes as $compressordowntime)
                <tr x-data="window.__controller.dataTableController({{ $compressordowntime->id }})">
                    <td>{{ $compressordowntime->id }}</td>
                    <td>{{ $compressordowntime->compressor->nombre }}</td>
                    <td>{{ $compressordowntime->compressor_causes_id }}</td>
                    <td>{{ $compressordowntime->fecha->format('d-m-Y')}}</td>
                    <td>{{ $compressordowntime->horas}}</td>
                    <td>{{ $compressordowntime->horas_paro_msa}}</td>
                    <td>{{ $compressordowntime->estado}}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $compressordowntime->estado!='Cerrado' ) 
                            <a role="button" href="/compressor/downtime/edit/{{ $compressordowntime->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
