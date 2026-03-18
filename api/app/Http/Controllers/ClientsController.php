<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos =Client::with('user')->get();
        return response()->json([
            'data'=>$datos,
        ]);
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
        $request->validate([

            'rfc' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'balance' => 'nullable|numeric',
            'id_user' => 'nullable|integer|exists:users,id'
        ]);

        $user = Client::create([

            'rfc' => $request->rfc,
            'address' => $request->address,
            'lat' => $request->lat ?? 0,
            'lng' => $request->lng ?? 0,
            'phone' => $request->phone,
            'balance' => $request->balance ?? 0.00,
            'id_user' => $request->id_user,
        ]);

        return response()->json([
            'data' => $user,
            'status' => 'success',
            'message' => 'Client created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos =Client::with('user')->where('id',$id)->first();
        $payments =Payment::where('id_client',$id)->get();
        $address = Address::where('id_client',$id)->get();
        return response()->json([
            'data'=>$datos,
            'payments'=>$payments,
            'address'=>$address,
            'success'=>!is_null($datos)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, $id)
{
    if (Client::where('id', $id)->exists()) {
        $request->validate([

            'rfc' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'balance' => 'nullable|numeric',
            'id_user' => 'nullable|integer|exists:users,id'
        ]);

        $client = Client::find($id);

        $client->rfc = $request->rfc;
        $client->address = $request->address;
        $client->lat = $request->lat;
        $client->lng = $request->lng;
        $client->phone = $request->phone;
        $client->balance = $request->balance;
        $client->id_user = $request->id_user;



        $client->save();

        return response()->json([
            "message" => "Client updated successfully",
            "data" => $client
        ], 200);

    } else {
        return response()->json([
            "message" => "Client not found"
        ], 404);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
