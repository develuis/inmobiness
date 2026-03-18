<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class RoutePackagesExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($packages)
    {
        $this->data = [];

        foreach ($packages as $p) {
            $this->data[] = [
                $p->package->address_to->street.' '.$p->package->address_to->exterior_number,//direccion
                $p->package->address_to->city,//Ciudad
                5,//duración
                $p->package->address_to->state,//estado
                'mexico',
                $p->package->track_number,
                $p->package->product,
                $p->package->client->user->name,
                $p->package->address_to->phone,//
                $p->package->client->phone,//
                '$'.$p->package->price,//
                'remitente',
                $p->package->address_to->between_streets,//ENTRE CALLES
                'NA'//Desc. Municipio
            ];
        }
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            "Direccion",
            "Municipio",
            "Duracion",
            "Estado",
            "Country",
            "Guía",
            "Producto",
            "Nombre cliente",
            "Celular Negocio",
            "Celular Cliente",
            "Cobro Cliente",
            "Remitente",
            "Entre Calles",
            "Desc. Municipio"
        ];
    }
}