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

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    public function events($from, $to) {
        return Event::whereBetween('date', [$from, $to])->get();
    }

    /**
     * @param $data
     * @return Event
     */
    public function create($data)
    {
        $event = new Event();
        $event->fill($data);
        $event->save();

        return $event;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function update($data)
    {
        $event = Event::find($data['id']);
        $event->fill($data);
        $event->save();

        return $event;
    }
}