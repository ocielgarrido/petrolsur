<div>
    <x-data-table :data="$data" :model="$tankcontrols">
        <x-slot name="head">
            <tr>
            
               <th class="text-nowrap"><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a>
                </th>
                <th class="text-nowrap  text-center"><a wire:click.prevent="sortBy('fecha')" role="button" href="#">
                    Fecha
                    @include('components.sort-icon', ['field' => 'fecha'])
                </a>
                </th>
               <th class="text-nowrap text-left"><a wire:click.prevent="sortBy('tank_id')" role="button" href="#">
                    Tanque
                    @include('components.sort-icon', ['field' => 'tank_id'])
                </a>
                </th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('agua')" role="button" href="#">
                    %Agua
                    @include('components.sort-icon', ['field' => 'agua'])
                </a>
                </th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('sales')" role="button" href="#">
                    Sales
                    @include('components.sort-icon', ['field' => 'sales'])
                </a>
                </th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('temp')" role="button" href="#">
                    Temp.
                    @include('components.sort-icon', ['field' => 'temp'])
                </a>
                </th>
                 <th class="text-nowrap"><a wire:click.prevent="sortBy('densidad')" role="button" href="#">
                    Dens.
                    @include('components.sort-icon', ['field' => 'densidad'])
                </a>
                </th>
                <th class="text-nowrap"><a wire:click.prevent="sortBy('estado')" role="button" href="#">
                    Estado 
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>
                <th class="text-nowrap">&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            
            @foreach ($tankcontrols as $tankcontrol)
                <tr x-data="window.__controller.dataTableController({{ $tankcontrol->id }})">
                    <td class="text-center text-nowrap">{{ $tankcontrol->id }}</td>
                    <td scope="col" class="text-center text-nowrap">{{ $tankcontrol->fecha->format('d-m-Y') }}</td>
                    <td scope="col" class="text-left text-nowrap">{{ $tankcontrol->tank->nombre}}</td>
                    <td class="text-right text-nowrap">{{ number_format($tankcontrol->agua,1)}}</td>
                    <td class="text-right text-nowrap">{{ number_format($tankcontrol->sales,0)}}</td>
                    <td class="text-right text-nowrap">{{ number_format($tankcontrol->temp,0)}}</td>
                    <td class="text-right text-nowrap">{{ number_format($tankcontrol->densidad,3)}}</td>
                     <td class="text-right text-nowrap">{{ $tankcontrol->estado}}</td>                    
                    <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $tankcontrol->estado!='Cerrado' ) 
                            <a role="button" href="/tankcontrol/edit/{{ $tankcontrol->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                            <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
