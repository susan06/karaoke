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
            'title' => 'Imaginándote',
            'artist' => 'Reykon y Daddy Yankee​',
        ]);

        Song::create([
            'title' => 'Como yo te quiero',
            'artist' => 'El Potro Alvarez y Yandel​',
        ]);

        Song::create([
            'title' => 'Me voy enamorando',
            'artist' => 'Chino y Nacho',
        ]);

        Song::create([
            'title' => 'Báilalo',
            'artist' => 'Tomas The Latin Boy',
        ]);

        Song::create([
            'title' => 'Baja',
            'artist' => 'Guaco',
        ]);

        Song::create([
            'title' => 'Vive la vida',
            'artist' => 'Sixto Rein con Chino y Nacho',
        ]);

        Song::create([
            'title' => 'Me marcharé',
            'artist' => 'Los Cadillacs con Wisin',
        ]);

        Song::create([
            'title' => 'Única',
            'artist' => 'Víctor Drija​',
        ]);

        Song::create([
            'title' => 'Siento bonito',
            'artist' => 'Juan Miguel',
        ]);

        Song::create([
            'title' => 'Déjate llevar',
            'artist' => 'Jonathan Moly',
        ]);
    }
}
