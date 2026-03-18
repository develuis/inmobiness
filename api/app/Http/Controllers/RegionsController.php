<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Zone;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    public function index()
    {
        $datos = Region::with(['zone.prices'])->get();
        $zones = Zone::with(['prices'])->get();
        
        return response()->json([
            'data'=>$datos,
            'zones'=>$zones,
        ]);
    }
}
