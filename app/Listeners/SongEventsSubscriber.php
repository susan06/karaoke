<?php

namespace App\Listeners;

use App\Activity;
use App\Events\Song\Created;
use App\Services\Logging\UserActivity\Logger;

class SongEventsSubscriber
{
    /**
     * @var UserActivityLogger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onCreate(Created $event)
    {
        $message = trans(
            'log.created_song',
            ['name' => $event->getCreatedSong()->title]
        );

        $this->logger->log($message);
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $class = 'App\Listeners\SongEventsSubscriber';

        $events->listen(Created::class, "{$class}@onCreate");

    }
}
