<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Payment;
class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
            'file' => 'required|file|mimes:jpeg,png,pdf|max:4048',
            'id_client'=>'required|exists:clients,id'
        ]);

        $file = $request->file('file');
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'_'.time().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('api/payments/');


        $file->move($destinationPath, $name);


        // Crear el registro en la base de datos
        $payment = Payment::create([
            'amount' => $validatedData['amount'],
            'file' => $name,
            'id_client' => $request->id_client,
            'confirmed'=>false
        ]);

        return response()->json([
            'message' => 'Pago registrado exitosamente',
            'payment' => $payment,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function showPaymentsUser($id)
    {
        try {
            $datos = Payment::where('id_client',$id)->get();
            $totalAmount = Payment::where('id_client', $id)->sum('amount');




            return response()->json([
                'data'=>$datos,
                'monto'=> $totalAmount,
                'mensaje'=>'Encontrado',

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el paquete',
                'error' => $th->getMessage()
            ], 500);
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function validatePay(Request $request){
        $payment = Payment::find($request->id);
        if(!$payment){
            return response()->json([
                'message' => 'Pago no encontrado',
            ], 404);
        }
        $payment->confirmed = true;
        $payment->save();
        $client = Client::find($payment->id_client);
        $client->balance += $payment->amount;
        $client->save();
        return response()->json([
            'message' => 'Pago validado exitosamente',
            'payment' => $payment,
        ], 200);
    }
}
