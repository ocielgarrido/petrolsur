<div class="col-md-12 table-responsive">
<div class="table table-hover table-condensed" border="0">
    <x-data-table :data="$data" :model="$welldowntimes">
        <x-slot name="head">
            <tr>
            
               <th scope="col" class="text-nowrap"><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th scope="col" class="text-nowrap"><a wire:click.prevent="sortBy('well_id')" role="button" href="#">
                    Pozo
                    @include('components.sort-icon', ['field' => 'well_id'])
                </a></th>
                <th scope="col" class="text-center text-nowrap"><a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                </a></th>
                <th scope="col" class="text-right text-nowrap"><a wire:click.prevent="sortBy('horas')" role="button" href="#">
                    Horas
                    @include('components.sort-icon', ['field' => 'horas'])
                </a></th>
                <th scope="col" class="text-right text-nowrap"><a wire:click.prevent="sortBy('well_cause_id')" role="button" href="#">
                    Causa.
                    @include('components.sort-icon', ['field' => 'well_cause_id'])
                </a></th>
                <th scope="col" class="text-right text-nowrap"><a wire:click.prevent="sortBy('agua_perdido_mt3')" role="button" href="#">
                    Agua mt3.
                    @include('components.sort-icon', ['field' => 'agua_perdido_mt3'])
                </a></th>
                <th scope="col" class="text-right text-nowrap"><a wire:click.prevent="sortBy('oil_perdido_mt3')" role="button" href="#">
                    Petróleo mt3.
                    @include('components.sort-icon', ['field' => 'oil_perdido_mt3'])
                </a></th>
                <th scope="col" class="text-right text-nowrap"><a wire:click.prevent="sortBy('gas_perdido_mt3')" role="button" href="#">
                    Gas mt3.
                    @include('components.sort-icon', ['field' => 'gas_perdido_mt3'])
                </a></th>
                <th scope="col" class="text-right text-nowrap"><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>
                <th scope="col">&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($welldowntimes as $welldowntime)
            
                <tr x-data="window.__controller.dataTableController({{ $welldowntime->id }})">
                    <td>{{ $welldowntime->id }}</td>
                    <td scope="col" class="text-right text-nowrap">{{ $welldowntime->well->pozo }}</td>
                    <td scope="col" class="text-center text-nowrap">{{ $welldowntime->fecha->format('d-m-Y')}}</td>
                    <td class="text-right">{{ $welldowntime->horas}}</td>
                    <td class="text-left">{{ $welldowntime->wellcause->causa }}</td>
                    <td class="text-right">{{ $welldowntime->agua_perdido_mt3}}</td>
                    <td class="text-right">{{ $welldowntime->oil_perdido_mt3}}</td>
                    <td class="text-right">{{ $welldowntime->gas_perdido_mt3}}</td>
                    <td class="text-right">{{ $welldowntime->estado}}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $welldowntime->estado!='Cerrado' ) 
                            <a role="button" href="/welldowntime/edit/{{ $welldowntime->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif    
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
</div>