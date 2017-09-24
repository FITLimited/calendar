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

    public function create(Request $request)
    {
        $result = new ActionResult();

        $data = $request->all();

        $rules = [
            'user_id'   => 'exists:users,id',
            'duration'  => 'required|numeric',
            'type'      => 'required|string',
            'date'      => 'required|date',
            'title'     => 'required|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $event = $this->eventRepository->create($data);

            $result->setData('event', $event);
            $result->success('');
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

//    public function remove(Request $request)
//    {
//        $event = Event::find("user_id", $request->id);
//        $event->delete();
//        return $request->id;
//    }
}