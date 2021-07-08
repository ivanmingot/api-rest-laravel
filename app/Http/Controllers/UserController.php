<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request){
		
		//collecting user data
		
		$json = $request->input('json', null);
		$params = json_decode($json);
		$params_array = json_decode($json, true);
	
		if(!empty($params) && !empty($params_array)){
			//Clean data
			$params_array = array_map('trim', $params_array);
			
			//Validate data
			
			$validate = \Validator::make($params_array, [
				'email' => 'required|string|email|max:255|unique:users',
				'name' => 'required',
				'password' => 'required'
			]);
			
			if($validate->fails()){
				$data = array(
					'status' => 'error',
					'code' => 404,
					'message' => 'The user could not be created',
					'errors' => $validate->errors()
				);
				
			}else{
				
				//encrypt password
				
				$pwd = hash('sha256', $params->password);
				
				//create user
				$user = new User();
				$user->name = $params_array['name'];
				$user->role = 'ROLE_USER';
				$user->email = $params_array['email'];
				$user->password = $pwd;
				$user->save();
				
				
				$data = array(
					'status' => 'success',
					'code' => 200,
					'message' => 'The user has been created with success'
					
				);
			}
			
		}else{
			$data = array(
					'status' => 'error',
					'code' => 404,
					'message' => 'The data is not correct',
					
				);
			
		}
		return response()->json($data);
		
		
	}
	
	public function login(Request $request){
		
		$jwtAuth = new \JwtAuth();
		
		
		$json = $request->input('json',null);
		$params = json_decode($json);
		$params_array = json_decode($json, true);
		
		$validate = \Validator::make($params_array, [
				'email' => 'required|email',
				'password' => 'required'
		]);
		
		if($validate->fails()){
			$signup = array(
				'status' => 'error',
				'code' => 404,
				'message' => 'The user has not been able to login',
				'errors' => $validate->errors()
			);
				
		}else{
			$pwd = hash('sha256', $params->password);
				
			$signup = $jwtAuth->signup($params->email, $pwd);
				
			if(!empty($params->gettoken)){
				$signup = $jwtAuth->signup($params->email, $pwd, true);
			}
		}
		
		return response()->json($signup, 200);
		
	}
	
	public function update(Request $request){
		$token = $request->header('Authorization');
		$jwtAuth = new \JwtAuth();
		$checkToken = $jwtAuth->checkToken($token);
		
		if($checkToken){
			echo '<h1>Correct Login</h1>';
		}else{
			echo '<h1>Incorrect Login</h1>';
		}
		die();
		
	}
	

}
