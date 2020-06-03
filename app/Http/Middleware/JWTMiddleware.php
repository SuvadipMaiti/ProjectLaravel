<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $message = '';
        try{
            //check token authenticate or not
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        }catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            //token invalid
            $message = 'Token invalid';
        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            //token expired
            $message = 'Token expired';
            
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            //token not provide
            $message = 'Provide token';
            
        }
        return response()->json([
            'success' => false,
            'message' => $message
        ]);
    }
}
