<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = new User();
        $user->name = 'admin';
		$user->role = 'ROLE_ADMIN';
        $user->email = 'admin@example.com';
        $user->password = hash('sha256', 123456);
	    $user->save();
		
		
    }
}
