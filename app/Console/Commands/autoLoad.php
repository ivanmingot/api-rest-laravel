<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class autoLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts from the REST API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //bring the posts from the rest api
		$url = env('URL_API');
		
		$response = Http::get($url)->json();
		
		
		if(!empty($response)){
			
			//save the post in ddbb

			$new_posts = $response['data'];
			
			foreach($new_posts as $posts){
				
				
			    $post = new Post;
				$post->user_id = 1;
				$post->title = $posts['title'];
				$post->description = $posts['description'];
				$post->publication_date = $posts['publication_date'];
				$post->save();
			}
		}
	}
   
}
