<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\RoutePackage;
use App\Exports\RoutePackagesExport;
use Maatwebsite\Excel\Facades\Excel;
class ExporterController extends Controller
{
    public function exportRoute($id)
    {
        $route = Route::with('user')->where('id', $id)->first();

        $packages = RoutePackage::where('id_route', $id)
            ->with([
                'package',
                'package.address_from',
                'package.address_to',
                'package.region',
                'package.type',
                'package.size',
                'package.weight',
                'package.pick',
                'package.client.user',
                'package.status'
            ])
           
            ->get();
      

        return Excel::download(new RoutePackagesExport($packages), 'route_packages.xlsx');
    }
}
