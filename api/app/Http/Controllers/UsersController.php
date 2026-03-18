<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use FIle;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(){
        $datos =User::select('users.*')->where('level','<=',2) ->get();
        return response()->json([
            'data'=>$datos,
        ]);
    }
    public function show($id){
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            return response()->json([
                "success"=>true,
                "data" => $user
            ]);
        }else{
            return response()->json([
                "success"=>false,
                "message" => "data Not Found."
            ], 201);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|required_with:password2|same:password_confirm',
            'password_confirm' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 3,
            'img' => 'default.jpg',
        ]);

        return response()->json([
            'data'=>$user,
            'status'=>'success'
        ]);
    }
    public function update(Request $request,$id){
        if (User::where('id', $id)->exists()) {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'level' => 'required',
            ]);

            $user =User::find($id);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->level=$request->level;
            $user->save();
            return response()->json(["message" => "Data Updated","data"=>$user], 201);


        }else{
            return response()->json(["message" => "data Not Found."], 201);
        }
    }
    public function destroy($id){
        if (User::where('id', $id)->exists()) {
            $entrada = User::find($id);
            if($entrada->img != "default.jpg"){
                if(File::exists( public_path('users/'.$entrada->img) )){
                    unlink( public_path('users/'.$entrada->img));
                }
            }
           $entrada->delete();
           return response()->json(["message" => "Data deleted"], 201);

        }else{
            return response()->json(["message" => "data Not Found."], 201);
        }


    }
    public function uploadImg(Request $req){
        $user=User::find($req->id);
        if($user->img !='default.jpg'){
            if(file_exists(public_path('api/users')."/".$user->img)){
            unlink(public_path('api/users')."/".$user->img);
            }
        }

        $image = $req->file('imagen');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('api/users');
        $req->imagen->move($destinationPath, $name);

        $user->img = $name;
        $user->save();
        return response()->json(["data"=>$name,"message" => "Data Updated."], 201);
        //return $name;
    }
    public function updatePassword(Request $request){
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)){
            return response()->json(["message" =>"error"], 201);
        }
        $user=User::where('email',$request->email)->first();
        $user->password=Hash::make($request->newPassword);
        $user->save();
        return response()->json(["message" => "Data Updated"], 201);
    }
}
