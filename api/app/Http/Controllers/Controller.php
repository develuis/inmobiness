<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
abstract class Controller
{
    protected function user() {
        return JWTAuth::parseToken()->authenticate();
    }
}
