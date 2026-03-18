<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
class AddressessController extends Controller
{
   
    /**
     * Display a listing of the resource.
     * Muestra las direecciones de un cliente por su sesion
     */
    public function index()
    {
        $addresses = Address::where('id_client', auth()->user()->id)->get();
        if ($addresses->isEmpty()) {
            return response()->json([
                'message' => 'No addresses found.',
                'status' => 'error',
            ], 404);
        }
        return response()->json([
            'data' => $addresses,
            'status' => 'success',
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'street' => 'required|string|max:255',
            'exterior_number' => 'required|string|max:50',
            'interior_number' => 'nullable|string|max:50',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'zip' => 'required|string|max:10',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'type' => 'required',
            'id_client' => 'required|exists:clients,id',
            'is_default'=>'required'
        ]);
        if($validatedData['is_default']['value'] == 1){
            Address::where('id_client',$validatedData['id_client'])
            ->where('type',$validatedData['type']['id'] == 'from' ? 'from' : 'to')
            ->update(['is_default'=>0]);
        }
        $address = Address::create([
            'street' => $validatedData['street'],
            'exterior_number' => $validatedData['exterior_number'],
            'interior_number' => $validatedData['interior_number'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'reference' => $validatedData['reference'],
            'zip' => $validatedData['zip'],
            'lat' => $validatedData['lat'],
            'lng' => $validatedData['lng'],
            'type' => $validatedData['type']['id'],
            'id_client' => $validatedData['id_client'],
            'is_default' => $validatedData['is_default']['value'],
        ]);
       
      
        

        return response()->json([
            'data' => $address,
            'status' => 'success',
        ], 201); 
    }
    
    /**
     * Display the specified resource.
     * get by id_client
     */
    public function show(string $id_client)
    {
        $addresses = Address::where('id_client', $id_client)->get();

        if ($addresses->isEmpty()) {
            return response()->json([
                'message' => 'No addresses found.',
                'status' => 'error',
            ], 404);
        }

        return response()->json([
            'data' => $addresses,
            'status' => 'success',
        ], 200);
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
        //remove address
        $address = Address::find($id);
        if (!$address) {
            return response()->json([
                'message' => 'Address not found.',
                'status' => 'error',
            ], 404);
        }
        $address->delete();
        return response()->json([
            'message' =>'Deleted successfully',
            'status' => 'success',
        ], 200);
    }

    public function predefAddress(Request $request){
        $address = Address::find($request->id);
        if (!$address) {
            return response()->json([
                'message' => 'Address not found.',
                'status' => 'error',
            ], 404);
        }
        Address::where('id_client',$request->id_client)
            ->where('type',$request->type == 'from' ? 'from' : 'to')
            ->update(['is_default'=>0]);
        $address->is_default = 1;
        $address->save();
        return response()->json([
            'message' =>'Updated successfully',
            'status' => 'success',
        ], 200);

    }
}
