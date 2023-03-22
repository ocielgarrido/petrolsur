<div>
    <x-data-table :data="$data" :model="$wellcontrols">
        <x-slot name="head">
            <tr>
            
               <th class="text-nowrap"><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th class="text-nowrap  text-center"><a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                </a></th>
               <th class="text-nowrap text-left"><a wire:click.prevent="sortBy('well_id')" role="button" href="#">
                    Pozo
                    @include('components.sort-icon', ['field' => 'well_id'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('horas')" role="button" href="#">
                    Horas
                    @include('components.sort-icon', ['field' => 'horas'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('prod_bruta_m3')" role="button" href="#">
                    P.Bruta
                    @include('components.sort-icon', ['field' => 'prod_bruta_m3'])
                </a>
                </th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('agua_emul_por')" role="button" href="#">
                    M3 Petroleo
                    @include('components.sort-icon', ['field' => 'agua_emul_por'])
                </a></th>
                 <th class="text-nowrap"><a wire:click.prevent="sortBy('oil_neto_mt3')" role="button" href="#">
                    M3 Agua
                    @include('components.sort-icon', ['field' => 'oil_neto_mt3'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('agua_neto_mt3')" role="button" href="#">
                    Mt3 Gas
                    @include('components.sort-icon', ['field' => 'agua_neto_mt3'])
                </a>
                </th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('gor')" role="button" href="#">
                    Gor 
                    @include('components.sort-icon', ['field' => 'gor'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('gas_inyectado')" role="button" href="#">
                    Gas Inyec.
                    @include('components.sort-icon', ['field' => 'gas_inyectado'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('agua_emul_por')" role="button" href="#">
                    % Agua 
                    @include('components.sort-icon', ['field' => 'agua_emul_por'])
                </a></th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado 
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>
                <th class="text-nowrap">&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            
            @foreach ($wellcontrols as $wellcontrol)
                <tr x-data="window.__controller.dataTableController({{ $wellcontrol->id }})">
                    <td class="text-center text-nowrap">{{ $wellcontrol->id }}</td>
                    <td scope="col" class="text-center text-nowrap">{{ $wellcontrol->fecha->format('d-m-Y') }}</td>
                    <td scope="col" class="text-left text-nowrap">{{ $wellcontrol->well->pozo}}</td>
                    <td class="text-right text-nowrap">{{ 24/$wellcontrol->horas*$wellcontrol->horas}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->prod_bruta_24}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->oil_neto_24}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->agua_neto_24}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->gas_neto_24}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->gor}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->gas_inyectado}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->agua_emul_por}}</td>
                    <td class="text-right text-nowrap">{{ $wellcontrol->estado}}</td>                    
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $wellcontrol->estado!='Cerrado' ) 
                            <a role="button" href="/wellcontrol/edit/{{ $wellcontrol->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
