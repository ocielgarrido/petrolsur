<?php

namespace App\Exports;

use App\Models\WellControl;
use App\Models\Well;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WellControlExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('pages.well.control.excel', [
         'controles'=> Well::join('well_controls', 'well_controls.well_id', '=', 'wells.id')
                       ->select('idpozo', 'pozo', 'cap_iv_nombre','pet','fecha', 'prod_bruta_mt3' ,
                        'agua_emul_por','oil_neto_mt3', 'agua_neto_24', 'gas_neto_mt3',
                        'prod_bruta_24')
                        ->orderBy('fecha','desc')
                        ->get()
        ]);
    }
}
