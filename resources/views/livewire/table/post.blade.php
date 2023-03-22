<div>
    <x-data-table :data="$data" :model="$posts">
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
                <th><a wire:click.prevent="sortBy('obs')" role="button" href="#">
                    Novedad.
                    @include('components.sort-icon', ['field' => 'obs'])
                </a></th>              
                <th><a wire:click.prevent="sortBy('esatdo')" role="button" href="#">
                    Estado.
                    @include('components.sort-icon', ['field' => 'estado'])
                </a></th>              
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($posts as $post)
                <tr x-data="window.__controller.dataTableController({{ $post->id }})">
                   <td>{{ $post->id }}</td>
                    <td>{{ $post->fecha->format('d-m-Y') }}</td>
                    <td>{{ $post->obs }}</td>
                    <td>{{ $post->estado }}</td>
                     <td class="whitespace-no-wrap row-action--icon">
                        @if((auth()->user()->roles->pluck('name')[0]!='Usuario' ) || $post->estado!='Cerrado' ) 
                           <a role="button" href="/post/edit/{{ $post->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                           <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                        @endif   
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
