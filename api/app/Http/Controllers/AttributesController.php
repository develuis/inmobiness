<?php

namespace App\Http\Controllers;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    public function index(){

        try {
            $attributes1 = Attribute::where('id_attribute', 1)->get();
            $attributes2 = Attribute::where('id_attribute', 2)->get();
            $attributes3 = Attribute::where('id_attribute', 3)->get();
            $attributes4 = Attribute::where('id_attribute', 4)->get();

            return response()->json([
                'message'=> 'Attributos encontrados',
                'attributes1' => $attributes1,
                'attributes2' => $attributes2,
                'attributes3' => $attributes3,
                'attributes4' => $attributes4,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar los attributos',
                'error' => $th->getMessage()
            ], 500);
        }



    }
}
