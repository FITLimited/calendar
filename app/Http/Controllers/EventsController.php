<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Event\EventService;
use App\Event;

class EventsController extends Controller
{
    protected $event_service;

    public function __construct(EventService $eventService)
    {
        $this->event_service = $eventService;
    }


    public function index(Request $request){
        $from = $request->from;
        $to = $request->to;
       return Event::whereBetween('date',[$from, $to])->get();
    }

    public function create(Request $request){
        return $this->event_service->add($request);
    }

}
