<?php

use App\Song;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Song::create([
            'name' => 'Imaginándote',
            'artist' => 'Reykon y Daddy Yankee​',
        ]);

        Song::create([
            'name' => 'Como yo te quiero',
            'artist' => 'El Potro Alvarez y Yandel​',
        ]);

        Song::create([
            'name' => 'Me voy enamorando',
            'artist' => 'Chino y Nacho',
        ]);

        Song::create([
            'name' => 'Báilalo',
            'artist' => 'Tomas The Latin Boy',
        ]);

        Song::create([
            'name' => 'Baja',
            'artist' => 'Guaco',
        ]);

        Song::create([
            'name' => 'Vive la vida',
            'artist' => 'Sixto Rein con Chino y Nacho',
        ]);

        Song::create([
            'name' => 'Me marcharé',
            'artist' => 'Los Cadillacs con Wisin',
        ]);

        Song::create([
            'name' => 'Única',
            'artist' => 'Víctor Drija​',
        ]);

        Song::create([
            'name' => 'Siento bonito',
            'artist' => 'Juan Miguel',
        ]);

        Song::create([
            'name' => 'Déjate llevar',
            'artist' => 'Jonathan Moly',
        ]);
    }
}
