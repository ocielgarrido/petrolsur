<?php

namespace App\Traits;



trait WithDataTable {
    
    public function get_pagination_data ()
    {
   
        switch ($this->name) {
            case 'consumo':
                $consumos= $this->model::search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);               
                return [
                    "view" => 'livewire.table.gasseconsumo',
                    "consumos" => $consumos,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('consumo.create'),
                            'create_new_text' => 'Nuevo Consumo',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;              
            case 'tankcontrol':
                    $tankcontrols = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                    return [
                        "view" => 'livewire.table.tankcontrol',
                        "tankcontrols" => $tankcontrols,
                        "data" => array_to_object([
                            'href' => [
                                'create_new' => route('tankcontrol.create'),
                                'create_new_text' => 'Nuevo Control',
                                'export' => '#',
                                'export_text' => 'Exportar'
                            ]
                        ])
                    ];
                    break;

            case 'compressordowntime':
                    $compresordowntimes = $this->model::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage);
    
                    return [
                        "view" => 'livewire.table.compressordowntime',
                        "compresordowntimes" => $compresordowntimes,
                        "data" => array_to_object([
                            'href' => [
                                'create_new' => route('downtime.create'),
                                'create_new_text' => 'Nuevo Registro',
                                'export' => '#',
                                'export_text' => 'Exportar'
                            ]
                        ])
                    ];
                    break;
            case 'oil':
                $oils = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.oil',
                    "oils" => $oils,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('oil.create'),
                            'create_new_text' => 'Nuevo Registro',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'oildetail':
                 $oildetails = $this->model::search($this->search)                
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);

                return [
                "view" => 'livewire.table.oilDetail',
                "oils" => $oildetails,
                "data" => array_to_object([
                    'href' => [
                        'create_new' => route('oildetail.create'),
                        'create_new_text' => 'Nuevo Registro',
                        'export' => '#',
                        'export_text' => 'Exportar'
                        ]
                    ])
                ];

                break;    
            case 'post':
                $posts = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.post',
                    "posts" => $posts,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('post.create'),
                            'create_new_text' => 'Nueva Novedad',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'wellcontrol':
                    $wellcontrols = $this->model::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage);
    
                    return [
                        "view" => 'livewire.table.wellcontrol',
                        "wellcontrols" => $wellcontrols,
                        "data" => array_to_object([
                            'href' => [
                                'create_new' => route('wellcontrol.create'),
                                'create_new_text' => 'Nuevo Control',
                                'export' => '#',
                                'export_text' => 'Exportar'
                            ]
                        ])
                    ];
                    break;
            case 'wellintervention':
                $wellinterventions = $this->model::search($this->search)               
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
                    return [
                        "view" => 'livewire.table.wellintervention',
                        "wellinterventions" => $wellinterventions,
                        "data" => array_to_object([
                            'href' => [
                                'create_new' => route('wellintervention.create'),
                                'create_new_text' => 'Nueva Intervención',
                                'export' => '#',
                                'export_text' => 'Exportar'
                            ]
                        ])
                    ];
                    break;
            case 'wellvariation':
                        $wellvariations = $this->model::search($this->search)               
                            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                            ->paginate($this->perPage);
                            return [
                                "view" => 'livewire.table.wellvariation',
                                "wellvariations" => $wellvariations,
                                "data" => array_to_object([
                                    'href' => [
                                        'create_new' => route('variation.create'),
                                        'create_new_text' => 'Nuevo ',
                                        'export' => '#',
                                        'export_text' => 'Exportar'
                                    ]
                                ])
                            ];
                            break;
            case 'welldowntime':
                $welldowntimes = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.welldowntime',
                    "welldowntimes" => $welldowntimes,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('welldowntime.create'),
                            'create_new_text' => 'Nueva Parada',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'well':
                $wells = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.well',
                    "wells" => $wells,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('well.create'),
                            'create_new_text' => 'Nuevo Pozo',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'product':
                $products = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.product',
                    "products" => $products,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('product.create'),
                            'create_new_text' => 'Nuevo Producto',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'sale':
                $sales = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.sale',
                    "sales" => $sales,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('sale.create'),
                            'create_new_text' => 'Nueva Venta',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'provider':
                $providers = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.provider',
                    "providers" => $providers,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('provider.create'),
                            'create_new_text' => 'Nuevo Proveedor',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'client':
                $clients = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.client',
                    "clients" => $clients,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('client.create'),
                            'create_new_text' => 'Nuevo Cliente',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'movement':
                $movements = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.movement',
                    "movements" => $movements,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('movement.create'),
                            'create_new_text' => 'Nuevo Movimiento',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'user':
                $users = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.user',
                    "users" => $users,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('user.new'),
                            'create_new_text' => 'Crear nuevo',
                            'export' => '#',
                            'export_text' => 'Exportar'
                        ]
                    ])
                ];
                break;
            case 'tank':
                    $tanks = $this->model::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage);
    
                    return [
                        "view" => 'livewire.table.tank',
                        "tanks" => $tanks,
                        "data" => array_to_object([
                            'href' => [
                                'create_new' => route('tank.create'),
                                'create_new_text' => 'Crear nuevo',
                                'export' => '#',
                                'export_text' => 'Exportar'
                            ]
                        ])
                    ];
                break;
            case 'gasse':

                        $gasses = $this->model::search($this->search)
                            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                            ->paginate($this->perPage);
        
                        return [
                            "view" => 'livewire.table.gasse',
                            "gasses" => $gasses,
                            "data" => array_to_object([
                                'href' => [
                                    'create_new' => route('gasse.create'),
                                    'create_new_text' => 'Crear nuevo',
                                    'export' => '#',
                                    'export_text' => 'Exportar'
                            ]
                       ])
                    ];
                break;       

            default:
                # code...
            break;
        }
    }
}