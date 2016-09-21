<?php

use App\Role;
use App\Support\Enum\UserStatus;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'admin_name',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'admin',
            'avatar' => null,
            'status' => UserStatus::ACTIVE
        ]);

        $admin = Role::where('name', 'admin')->first();

        $user->attachRole($admin);

    }
}
