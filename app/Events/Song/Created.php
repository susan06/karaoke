<?php

namespace App\Events\Song;

use App\Song;

class Created
{
    /**
     * @var Song
     */
    protected $createdSong;

    public function __construct(Song $createdSong)
    {
        $this->createdSong = $createdSong;
    }

    /**
     * @return Song
     */
    public function getCreatedSong()
    {
        return $this->createdSong;
    }
}
