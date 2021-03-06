<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(SongSeeder::class);
        //$this->call(ReservationSeed::class);
        $this->call(BrachOfficeSeeder::class);

        Model::reguard();
    }
}
