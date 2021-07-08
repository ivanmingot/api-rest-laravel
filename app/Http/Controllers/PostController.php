<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;
use App\Helpers\JwtAuth;
use App\Models\User;
use Illuminate\Support\Facades\Http;


class PostController extends Controller
{
    public function __construct(){
		$this->middleware('api.auth', ['except' => ['index', 'show','getImage']]);
	}
	
	
	public function index(Request $query){
		
		$json = $query->input('json', null);
		$dates = json_decode($json);
		
		//SEARCH JUST ONE DATE
		if($dates->from == "" AND $dates->to == ""){
			$posts = Post::search($dates->q)->load('user');
			return response()->json([
				'code' => 200,
				'status' => 'success',
				'posts' => $posts,
				'dates' => $dates->q
			], 200);
       }
	   
	   //SEARCH TWO DATES
	   if($dates->q == ""){
			$posts= POST::where("publication_date",">=",$dates->from)
             ->where("publication_date","<=",$dates->to)
			 ->orderBy('id','ASC')
             ->get()->load('user');
			return response()->json([
				'code' => 200,
				'status' => 'success',
				'posts' => $posts,
				
			], 200);
       }
	}
	
	public function show($id){
		$post = Post::find($id)->load('user');
		
		if(is_object($post)){
			$data = [
				'code' => 200,
				'status' => 'success',
				'post' => $post
			];
		}else{
			$data = [
				'code' => 404,
				'status' => 'error',
				'message' => 'The post does not exist'
			];
		}
		return response()->json($data, $data['code']);
	}
	public function store(Request $request){
	
		$json = $request->input('json', null);
		$params = json_decode($json); //Object
		$params_array = json_decode($json, true);//Array
		
		if(!empty($params_array)){
			
			//check identified user
			$jwtAuth = new JwtAuth();
			$token = $request->header('Authorization', null);
			$user = $jwtAuth->checkToken($token, true);
			
			//validate the data
			$validate = \Validator::make($params_array, [
				'title' =>'required',
				'description' => 'required'
			]);
			
			if($validate->fails()){
				$data = [
				'code' => 400,
				'status' => 'error',
				'message' => 'Missing data'
				];
				
			}else{
				//Save the post
				$post = new Post;
				$post->user_id = $user->sub;
				$post->title = $params->title;
				$post->description = $params->description;
				$post->image = $params->image;
				$post->publication_date = date('Y-m-d');
				$post->save();
				
				$data = [
				'code' => 200,
				'status' => 'success',
				'message' => 'Post saved successfully',
				'post' =>$params_array
				];
			}
		}else{
			$data = [
				'code' => 400,
				'status' => 'error',
				'message' => 'send the data correctly'
				];
		}
		
		return response()->json($data, $data['code']);
	}
	
	public function upload(Request $request){
		
		//Collect the image of the petition
		
		$image = $request->file('file0');
		
		//validate image
		
		$validate = \Validator::make($request->all(),[
			'file0' => 'required'
		]);
		
		//Save the image
		
		if(!$image || $validate->fails()){
			$data = [
				'code' => 400,
				'status' => 'error',
				'message' => 'error uploading the image'
			];
		}else{
			$image_name = time() . $image->getClientOriginalName();
			\Storage::disk('images')->put($image_name, \File::get($image));
			
			$data = [
				'code' => 200,
				'status' => 'success',
				'message' => 'Image uploaded to server',
				'image' => $image_name
			];
		}
		//return data
		return response()->json($data, $data['code']);
	}
	
	public function getImage($filename){
		
		//check if the file exists
		$isset = \Storage::disk('images')->exists($filename);
		
		if($isset){
		//get the image
		$file = \Storage::disk('images')->get($filename);
		
		//return the image
		return new Response($file, 200);
		}else{
			$data = [
				'code' => 404,
				'status' => 'error',
				'message' => 'Image no exist',
				'image' => $image_name
			];
		}
		return response()->json($data, $data['code']);
	}
	public function getPostsByDates($date){
		
		$posts = Post::WHERE('created_at', $date)->get();
		
		return response()->json([
			'status' => 'success',
			'posts' => $posts
		], 200);
	}
	public function getMyPosts($id){
		
		$posts = Post::WHERE('user_id', $id)->get();
		$user = User::find($id);
		
		return response()->json([
			'status' => 'success',
			'posts' => $posts,
			'user' => $user
		], 200);
	}
	
}
