<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Status;
use App\Models\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
class PackagesController extends Controller
{
    public function filterByStatus($id)
    {
        $datos = Package::with([
                'region',
                'address_from',
                'address_to',
                //'client',
                'type',
                'size',
                'weight',
                'pick',
                'client.user',
                'status'
        ])
        ->where('status',$id)
        ->get();
        $status = Status::all();


        $distinct_days = $datos->map(function ($package) {
            return Carbon::parse($package->pick_date)->format('Y-m-d');
        })
        ->unique()
        ->sort()
        ->values()
        ->map(function ($date) {
            return [
                'date' => $date,
                'day_name' => ucfirst(Carbon::parse($date)->locale('es')->isoFormat('dddd')),
                'day_number'=>Carbon::parse($date)->day
            ];
        });
        return response()->json([
            'data'=>$datos,
            'status'=>$status,
            'distinct_days'=>$distinct_days,
        ]);
    }
    public function show($track_number)
    {
        $datos = Package::with([
            'region',
            'address_from',
            'address_to',
            //'client',
            'type',
            'size',
            'weight',
            'pick',
            'client.user',
            'status'
        ])->where('track_number',$track_number)->first();
        return response()->json([
            'status'=>$datos == null ? 'not_found' : 'success',
            'data'=>$datos
        ]);



    }


    public function getPackagesByClient($id)
    {
        $datos = Package::with([
            'region',
            'address_from',
            'address_to',
            //'client',
            'type',
            'size',
            'weight',
            'pick',
            'client.user',
            'status'
        ])->where('id_client',$id)->get();
        return response()->json([
            'status'=>$datos == null ? 'not_found' : 'success',
            'data'=>$datos
        ]);



    }





    public function store(Request $request){

        $validator = Validator::make($request->all(), [
           /* 'tipo_paquete' => 'required',
            'size' => 'required',
            'tipo_destino' => 'required',
            'date_recoleccion' => 'required',
            'peso' => 'required',
            'recoleccion' => 'required',

            'remitenteName' => 'required',
            'remitentePhone' => 'required',
            'remitenteDireccion' => 'required',

            'destinatarioName' => 'required',
            'destinatarioTelefono' => 'required',
            'destinatarioDireccion' => 'required',
*/

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $payForPackage =$request->size + $request->peso;

            $package = Package::create([
                'id_region' => 1,
                'id_address_from' => 1,
                'id_address_to' => 2,
                'id_client' => $request->id_cliente,
                'id_type' => $request->size,
                'id_size' => $request->tipo_paquete,
                'id_weight' => $request->peso,
                'product' => $request->producto,
                'id_pick' => 14,
                'address_type' => $request->tipo_destino,
                'note' => 'note2',
                'price' => $payForPackage,
                'status' => 1,
                'pick_date' => $request->date_recoleccion,
                'track_number' => 'PT'.$request->id_cliente,
                'id_region' => 1,

            ]);

            $userAmount = Payment::where('id_client', $request->id_cliente)->first();

            if (!$userAmount) {
                return response()->json([
                    'message' => 'Cliente no encontrado en registros de pago',
                    'clie' => $userAmount
                ], 404);
            }

            if ($userAmount->amount < 0 || $payForPackage > $userAmount->amount) {
                return response()->json([
                    'message' => 'Saldo insuficiente',
                    'current_balance' => $userAmount->amount,
                    'required_amount' => $payForPackage
                ], 400);
            }

            $userAmount->amount -= $payForPackage;
            $userAmount->save();

            return response()->json([
                'success' => true,
                'message' => 'Paquete creado exitosamente',
                'data' => $package,
                'new_balance' => $userAmount->amount
            ], 201);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el paquete',
                'error' => $th->getMessage()
            ], 500);
        }



    }
    public function destroy($id){
        if (Package::where('id', $id)->exists()) {
            $p = Package::find($id);
            $p->status = 6;
            $p->save();
            return response()->json(["message" => "Data Updated"], 201);
        }else{
            return response()->json(["message" => "data Not Found."], 201);
        }
    }
}
