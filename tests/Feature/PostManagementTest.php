<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;


class PostManagementTest extends TestCase
{
	
	
    public function a_post_can_be_created()
    {
			$user = factory(User::class)->create();
			$response = $this->actingAs($user, 'api')
				->json('post', '/api/post/store', [
					'title' => 'test_title',
					'description' => 'test_description',
					'publication_date' => '2021-03-03'
				]);

			$response->assertStatus(200);
			
	}
    /** @test */
    public function a_post_can_be_shown()
    {
		$response = $this->get('/api/post/1');
		
		$response->assertJsonStructure(['status','code'])
		         ->assertJson(['status'=>'success'])
				 ->assertStatus(200);
	}
}
