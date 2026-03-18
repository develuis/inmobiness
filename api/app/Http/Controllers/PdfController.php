<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Barryvdh\DomPDF\Facade\Pdf;
class PdfController extends Controller
{
    public function show($track_number)
    {
        $data = Package::with([
            'region',
            'address_from',
            'address_to',
            'address_to.client',
            'address_to.client.user',
            //'client',
            'type',
            'size',
            'weight',
            'pick',
            'client.user',
            'status'
        ])->where('track_number',$track_number)->first();
        //dd($data);
        $path = public_path('/logo-black.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
                
        $img = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
        $item= compact('data','base64');
        $pdf = Pdf::loadView('reports.guia', $item);
        return $pdf->stream();
  

    }
}
