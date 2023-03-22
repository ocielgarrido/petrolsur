<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OilDetail;

class OilDetailController extends Controller
{
    public function index()
    {
     //   abort_if(Gate::denies('Oil'), 403); 
        return view('pages.oil.detail.oildetail-data', [
            'oildetail' => OilDetail::class
        ]);
    }
}
