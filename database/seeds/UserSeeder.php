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
            'password' => 'secret',
            'avatar' => null,
            'status' => UserStatus::ACTIVE
        ]);

        $superadmin = Role::where('name', 'superAdmin')->first();

        $user->attachRole($superadmin);

        $user = User::create([
            'first_name' => 'admin_name',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'secret',
            'avatar' => null,
            'status' => UserStatus::ACTIVE
        ]);

        $admin = Role::where('name', 'admin')->first();

        $user->attachRole($admin);

        $user = User::create([
            'first_name' => 'dj_name',
            'email' => 'dj@dj.com',
            'username' => 'dj',
            'password' => 'secret',
            'avatar' => null,
            'status' => UserStatus::ACTIVE
        ]);

        $dj = Role::where('name', 'dj')->first();

        $user->attachRole($dj);

    }
}
