@php
$links = [
    [
        "href" => "report",
        "text" => "Reportes",
        "is_multi" => false,
        'icon' =>'fa fa-user',
        'can' =>"Reportes"
 
    ],
    [
        "href" => [
            [
                "section_text" => "Roles y Usuario",
                "section_list" => [
                    ["href" => "permission.index", "text" => "Permisos", "icon"=>"fa fa-user","can" =>"Permisos"],
                    ["href" => "roles.index", "text" => "Roles", "icon"=>"fa fa-user","can" =>"Roles"],
                    ["href" => "users.index", "text" => "Usuarios", "icon"=>"fa fa-user","can" =>"Usuarios"],
  
                ],
       
            ]
        ],
        "text" => "Roles y Usuarios",
        "is_multi" => true,
        'icon' =>'fa fa-user'
 
    ],
    [
        "href" => [
            [
                "section_text" => "Tablas de sistema",
                "section_list" => [
                
                    ["href" => "area", "text" => "Areas", "icon"=>"fa fa-user","can" =>"Areas"],
                    ["href" => "well", "text" => "Pozos", "icon"=>"fa fa-user","can" =>"Pozos"],
                    ["href" => "tank", "text" => "Tanques", "icon"=>"fa fa-user","can" =>"Tanques"],
                    ["href" => "client", "text" => "Clientes", "icon"=>"fa fa-user","can" =>"Clientes"],
                    ["href" => "provider", "text" => "Proveedores", "icon"=>"fa fa-user","can" =>"Proveedores"],
                    ["href" => "product", "text" => "Productos", "icon"=>"fa fa-user","can" =>"Producto"],
        
                ],
       
            ]
        ],
        "text" => "Tablas de Sistema",
        "is_multi" => true,
        'icon' =>'fa fa-user'
 
    ],
  
    [
        "href" => [
            [
                "section_text" => "Carga de datos",
                "section_list" => [
                    ["href" => "tankcontrol", "text" => "Control de Tanques", "icon"=>"fa fa-user","can" =>"Oil"],
                    ["href" => "wellcontrol", "text" => "Control de Pozo", "icon"=>"fa fa-user","can" =>"Oil"],
                    ["href" => "welldowntime", "text" => "Parada de Pozo", "icon"=>"fa fa-user","can" =>"Oil"],
                    ["href" => "downtime", "text" => "Paradas Motocompresor", "icon"=>"fa fa-user","can" =>"Ventas"],
                    ["href" => "sale", "text" => "Ventas", "icon"=>"fa fa-user","can" =>"Ventas"],
                    ["href" => "movement", "text" => "Movimientos", "icon"=>"fa fa-user","can" =>"Movimientos"],
                    ["href" => "wellintervention", "text" => "Intervención a Pozo", "icon"=>"fa fa-user","can" =>"Movimientos"],
                    ["href" => "post", "text" => "Novedades", "icon"=>"fa fa-user","can" =>"Movimientos"],
                    ["href" => "variation", "text" => "Incrementos /Mermas", "icon"=>"fa fa-user","can" =>"Movimientos"],
                    ["href" => "consumo", "text" => "Consumo Gas", "icon"=>"fa fa-user","can" =>"Gas"],
                    ["href" => "gasse", "text" => "Datos Gas", "icon"=>"fa fa-user","can" =>"Gas"],
                    ["href" => "oil", "text" => "Datos tanques", "icon"=>"fa fa-user","can" =>"Oil"],
         
                ],
       
            ]
        ],
        "text" => "Carga de Datos",
        "is_multi" => true,
        'icon' =>'fa fa-user'
    ],
    [
        "href" => [
            [
                "section_text" => "Procesos Periódicos",
                "section_list" => [
                
                    ["href" => "area", "text" => "DDJJ Cap. IV", "icon"=>"fa fa-user","can" =>"Areas"],
                    ["href" => "well", "text" => "DDJJ Sesco", "icon"=>"fa fa-user","can" =>"Pozos"],
                    ["href" => "tank", "text" => "Regalias", "icon"=>"fa fa-user","can" =>"Tanques"],
        
                ],
       
            ]
        ],
        "text" => "Procesos Periódicos",
        "is_multi" => true,
        'icon' =>'fa fa-user'
 
    ],
    [
        "href" => [
            [
                "section_text" => "Utilidades",
                "section_list" => [
                    ["href" => "backups", "text" => "Backup Base Datos", "icon"=>"fa fa-user","can" =>"Backup"],
         
                ],
       
            ]
        ],
        "text" => "Utilidades",
        "is_multi" => true,
        'icon' =>'fa fa-user'

    ],
];
$navigation_links = array_to_object($links);
//dd($navigation_links);
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper" style="border-style: solid; !important; border-color: #df7e37; !important">
        <div class="sidebar-brand">
            <img src="{{ asset('img/petrolsur.png') }}" width="200" height="100"/>  
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('report') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="{{asset('img/logo.png')}}" alt="">
            </a>
        </div>
       
        @foreach ($navigation_links as $link)
        <ul class="sidebar-menu">
           
            <li class="menu-header">{{ $link->text }}</li>
            @if (!$link->is_multi)
            <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                @can($link->can) 
                   <a class="nav-link" href="{{ route($link->href) }}"><i class="fas fa-fire"></i><span>{{$link->text}}</span></a>
                @endcan
            </li>
            @else
                @foreach ($link->href as $section)
                    @php
                    $routes = collect($section->section_list)->map(function ($child) {
                        return Request::routeIs($child->href);
                    })->toArray();

                    $is_active = in_array(true, $routes);
                    @endphp

                    <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-arrow-right"></i> <span>{{ $section->section_text }}</span></a>
                        <ul class="dropdown-menu">
                           
                            @foreach ($section->section_list as $child)   
                              @can($child->can)                       
                                 <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                              @endcan                             
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>
        @endforeach
    </aside>
</div>
