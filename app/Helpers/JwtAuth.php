<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JwtAuth{
	
	public $key;
	
	public function __construct(){
		$this->key ='this_is_a_super_secret_key-0078945';
	}

	public function signup($email, $password, $getToken = null){
		
		$user = User::WHERE([
			'email' => $email,
			'password' => $password
		])->first();
		
		$signup = false;
		if(is_object($user)){
			$signup = true;
		}
		
		if($signup){
			$token = array(
				'sub' => $user->id,
				'email' => $user->email,
				'name' => $user->name,
				'iat' => time(),
				'exp' => time() + (7 * 24 * 60 * 60) //1 week token
			);
			
			$jwt = JWT::encode($token, $this->key, 'HS256');
			$decoded = JWT::decode($jwt, $this->key, ['HS256']);
			
			if(is_null($getToken)){
				$data = $jwt;
			}else{
				$data = $decoded;
			}
			
		}else{
			$data = array(
				'status' => 'error',
				'message' => 'Incorrect login'
			);
		}
		
		return $data;
	}
	
	public function checkToken($jwt, $getIdentity = false){
		$auth = false;
		
		try{
			$jwt = str_replace('"', '', $jwt);
			$decoded = JWT::decode($jwt, $this->key, ['HS256']);
		}catch(\UnexpectedValueException $e){
			$auth = false;
		}catch(\DomainException $e){
			$auth = false;
		}
		
		if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
			$auth = true;
		}else{
			$auth = false;
		}
		if($getIdentity){
			return $decoded;
		}
		return $auth;
	}
}