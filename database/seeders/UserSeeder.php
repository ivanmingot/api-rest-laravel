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
        $user->password = bcrypt('123456');
	    $user->save();
		
		$user = new User();
        $user->name = 'user1';
		$user->role = 'ROLE_USER';
        $user->email = 'user@example.com';
        $user->password = bcrypt('123456');
	    $user->save();
    }
}
