<?php

namespace App\Repositories\Event;

use App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    public $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function events($from, $to) {
        return Event::whereBetween('date', [$from, $to])->get();
    }
}