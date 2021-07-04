<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		$token = $request->header('Authorization');
		$jwtAuth = new \JwtAuth();
		$checkToken = $jwtAuth->checkToken($token);
		
		if($checkToken){
			 return $next($request);
		}else{
			$data = array(
				'status' => 'error',
				'code' => 400,
				'message' => 'Unidentified user',
			);
			
			return response()->json($data, $data['code']);
			
		}
       
    }
}
