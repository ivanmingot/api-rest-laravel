<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserManagementTest extends TestCase
{
	
    /** @test */
    public function register()
    {
		$data = [
			'name' => 'peter',
			'password' => '123456',
			'email' => "pere@pere.es"
		];
		$json = json_encode($data);
        $response = $this->post('/api/register',['json' => $json]);
	
        
		$this->assertDatabaseHas('users', ["name" =>"peter", "email" => "pere@pere.es"]);
    }
	
	/** @test */
    public function login()
    {
		$data = [
			'password' => '123456',
			'email' => "pere@pere.es"
		];
		$json= json_encode($data);
        $response = $this->post('/api/login',['json' => $json]);
	
        
		$response->assertStatus(200);
    }
}
