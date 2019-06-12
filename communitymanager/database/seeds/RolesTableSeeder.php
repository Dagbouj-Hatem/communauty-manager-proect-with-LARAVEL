<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert the 

    	 Role::create(['name' => 'Utilisateur']);
       Role::create(['name' => 'Administrateur' ]);

       
    }
}
