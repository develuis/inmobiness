<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Zone;

class CotizacionController extends Controller
{
    public function index()
    {
        $datos = Region::with(['zone.prices'])->get();
        $zones = Zone::with(['prices'])->get();
        
        return response()->json([
            'citys'=>$datos,
            'zones'=>$zones,
            'dimensiones'=>Attribute::where('id_attribute',1)->get(),
            'tipospaquete'=>Attribute::where('id_attribute',2)->get(),
            'pesos'=>Attribute::where('id_attribute',3)->get(),
            'tipo_recoleccion'=>Attribute::where('id_attribute',4)->get()
        ]);
    }
}
