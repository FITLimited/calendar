<?php
namespace App\Services\Event;

use Validator;
use Illuminate\Http\Request;

use App\Helpers\ActionResult;
use App\Repositories\Event\EventRepositoryInterface;

class EventService
{
    protected $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    public function getEvents(Request $request) {
        $result = new ActionResult();

        $data = $request->all();

        $rules = [
            'from' => 'required|date',
            'to' => 'required|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $events = $this->eventRepository->events($data['from'], $data['to']);

            $result->setData('events', $events);
            $result->success('');
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

//    public function create(Request $request)
//    {
//        $event = new Event();
//        $event->user_id = $request->user_id;
//        $event->duration = $request->duration;
//        $event->type = $request->type;
//        $event->date = $request->date;
//        $event->title = $request->title;
//        $event->created_at = date("Y-m-d H:i:s");
//        $event->updated_at = date("Y-m-d H:i:s");
//        $event->save();
//
//        return $event;
//    }
//
//    public function remove(Request $request)
//    {
//        $event = Event::find("user_id", $request->id);
//        $event->delete();
//        return $request->id;
//    }
}