<?php

use App\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reservation::create([
            'num_table' => 1,
            'user_id' => 1,
            'date' => '2016-10-06',
            'time' => '06:00'
        ]);
        Reservation::create([
            'num_table' => 1,
            'user_id' => 2,
            'date' => '2016-10-06',
            'time' => '07:00'
        ]);
        Reservation::create([
            'num_table' => 1,
            'user_id' => 3,
            'date' => '2016-10-06',
            'time' => '08:00'
        ]);
    }
}
