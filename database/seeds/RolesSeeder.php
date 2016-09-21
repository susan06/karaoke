<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'System administrator.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'Default system user.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'dj',
            'display_name' => 'DJ',
            'description' => 'Default system DJ.',
            'removable' => false
        ]);
    }
}
