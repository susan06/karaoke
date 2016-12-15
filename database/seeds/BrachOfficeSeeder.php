<?php

use App\BrachOffice;
use Illuminate\Database\Seeder;

class BrachOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BrachOffice::create([
            'name' => 'sucursal 1',
            'email_song' => 'email@example.com',
            'email_reservations' => 'email@example.com', 
            'lat' => 8.994716,
            'lng' => -79.514766,
            'radio' => 50
        ]);

        BrachOffice::create([
            'name' => 'sucursal 2',
            'email_song' => 'email@example.com',
            'email_reservations' => 'email@example.com', 
            'lat' => 8.994716,
            'lng' => -79.514766,
            'radio' => 50
        ]);
    }
}
