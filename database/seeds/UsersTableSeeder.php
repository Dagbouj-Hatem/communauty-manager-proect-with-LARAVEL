<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // insert  admin 

    	 User::create([
        'name' => 'Admin Account',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'mobile'=> '+5446870594591',
        'role' => 1,
        'photo'=> null, 
        'remember_token' => str_random(10),
        'created_at' =>now(),
        'updated_at' =>now(),
   		 ])->assignRole('Administrateur');

    	// insert user  

    	 User::create([
        'name' => 'User Account',
        'email' => 'user@gmail.com',
        'password' => bcrypt('password'),
        'mobile'=> '+5446870594591',
        'role' => 0,
        'photo'=> null, 
        'remember_token' => str_random(10),
        'created_at' =>now(),
        'updated_at' =>now(),
   		 ])->assignRole('Utilisateur');

   		 // insert 28 others users

        factory(App\User::class, 28)->create()->each(function ($user) {

                // Adding permissions via a role 
                if($user->role)
                {
                    $user->assignRole('Administrateur');
                }
                else
                {
                    $user->assignRole('Utilisateur');
                }
                // end roles 
         });
    }
}
