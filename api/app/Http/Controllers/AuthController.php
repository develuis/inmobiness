<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthController extends Controller
{
    public function register(Request $request)
    {

            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required',
                        'password' => 'required',
                    ]);

                    if($validator->fails()){
                        return response()->json($validator->errors()->toJson(), 400);
                    }
        try{
                    $user = User::create([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'password' => Hash::make($request->get('password')),
                        'level' => 3,
                        'img' => 'default.jpg'
                    ]);

                   // $token = JWTAuth::fromUser($user);

                    return response()->json(compact('user'), 201);
            }catch(Exception $e){
                    return response()->json(['error' => 'Error al registrar el usuario.'], 500);
            }
    }

    // User login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $access_token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = auth()->user();

            // (optional) Attach the role to the token.
           // $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('access_token','user'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // Get authenticated user
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
