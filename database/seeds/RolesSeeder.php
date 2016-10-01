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
            'name' => 'superAdmin',
            'display_name' => 'Super Admininistrador',
            'description' => 'System Super administrator.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'admin',
            'display_name' => 'Administradores',
            'description' => 'System administrator.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'user',
            'display_name' => 'Clientes',
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
