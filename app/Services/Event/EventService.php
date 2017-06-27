<?php
namespace App\Services\Event;
use Illuminate\Http\Request;
use App\Event;

class EventService
{
    public function add(Request $request)
    {
        $event = new Event();
        $event->user_id = $request->user_id;
        $event->duration = $request->duration;
        $event->type = $request->type;
        $event->date = $request->date;
        $event->title = $request->title;
        $event->created_at = date("Y-m-d H:i:s");
        $event->updated_at = date("Y-m-d H:i:s");
        $event->save();

        return $event;
    }
}