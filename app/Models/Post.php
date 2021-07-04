<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
	
	protected $table = 'posts';
	
	//One To Many (Inverse)
	
	public function user(){
		return $this->belongsTo(User::class);
	}
	//Here we can filter posts by date
	public static function search($query=''){
		if(!$query){
			return self::all()->load('user');
		}else{
			return self::where('publication_date', 'like', "%$query%")->get();
		}
	}
}
