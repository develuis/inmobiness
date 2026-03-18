<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Route;
use App\Models\RoutePackage;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class RoutesController extends Controller
{
    
    public function index(){
        if(Auth::user()->level == 1){
          $datos =Route::with('user')->get();
          $data=[];
          foreach ($datos as $value) {
            $data[]=[
              'route'=>$value,
              'packages'=>RoutePackage::where('id_route',$value->id)->with('package')->get()
            ];
          }
          
        }else{
          $datos =Route::with('user')->where('id_user',Auth::user()->id)->get();
          $data=[];
          foreach ($datos as $value) {
            $data[]=[
              'route'=>$value,
              'packages'=>RoutePackage::where('id_route',$value->id)->with('package')->get()
            ];
          }
        }
        return response()->json([
              'data'=>$data,
          ]);
          
    }
    
    public function getReadyPackages(Request $request){
        $datos = Package::with([
          'region',
          'address_from',
          'address_to',
          'type',
          'size',
          'weight',
          'pick',
          'client.user',
          'status'
        ])
          ->where('status',1)
          ->where('pick_date',$request->start_date)
          ->get();


        $users = User::where('level',2)->get();

        return response()->json([
            'packages'=>$datos,
            'users'=>$users,
        ]);
    }
    public function store(Request $request){
     
      $request->validate([
        'data' => 'required',
        'users' => 'required',
        'start_date' => 'required'
      ]);
     
      //iterando los usuarios que si tienen paquetes
      foreach($request->users as $user){
        if($user['total'] > 0 ){
          $r = Route::create([
            'id_user'=>$user['id'],
            'start_date'=>$request->start_date,
            'status'=>"Pendiente",
            'file'=>"",
            'end_date'=>$request->start_date,
          ]);
          Log::info($r);
          //buscando los paquetes referentes al usuario
          foreach( $request->data as $value){
            //if($value['user'] !=null ){
              if($value['id_user'] == $user['id']){
                Log::info("INSERTANDO");
                Log::info(json_encode([
                  'id_route'=>$r->id,
                  'id_package'=>$value['id'],
                ]));
                RoutePackage::create([
                  'id_route'=>$r->id,
                  'id_package'=>$value['id'],
                ]);
   
                $p = Package::find($value['id']);
                $p->status = 2;
                $p->save();
              }

            //}
           
          }
        
        }



      }
      return response()->json([
        'status'=>'success'
      ]);
      
    }
    public function show($id){
        $datos =Route::with('user')->find($id);
        $data=[
          'route'=>$datos,
          'packages'=>RoutePackage::where('id_route',$datos->id)
            ->with([
              'package',
              'package.region',
              'package.address_from',
              'package.address_to',
              'package.client',
              'package.type',
              'package.size',
              'package.weight',
              'package.weight',
              'package.client.user',
              'package.status'
              
            ])->get()
        ];
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function deleteFromRoute(Request $request){
      $id = $request->id;
      $datos = RoutePackage::find($id);
      $p = Package::find($datos->id_package);
      $p->status = 1;
      $p->save();
      $datos->delete();
      return response()->json([
          'status'=>'success'
      ]);
    }
    public function destroy($id){
      $datos = Route::find($id);
      //remove all packages from route
      $packages = RoutePackage::where('id_route',$id)->get();
      foreach($packages as $value){
        $p = Package::find($value->id_package);
        $p->status = 1;
        $p->save();
        $value->delete();
      }
      $datos->delete();
      return response()->json([
          'status'=>'success'
      ]);
    }
}
