<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Services\Event\EventService;
use App\Http\Controllers\BaseApiController;

class EventController extends BaseApiController
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function getEvents(Request $request)
    {
        $result = $this->eventService->getEvents($request);

        return $this->apiResponse($result);
    }
//
//    public function create(Request $request)
//    {
//        return $this->event_service->create($request);
//    }

}
