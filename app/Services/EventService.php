<?php
namespace App\Services\Event;

use Validator;
use Illuminate\Http\Request;

use App\Helpers\ActionResult;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Event\EventRepositoryInterface;

class EventService
{
    protected $eventRepository;
    protected $userRepository;

    public function __construct(EventRepositoryInterface $eventRepository,
                                UserRepositoryInterface $userRepository) {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return ActionResult
     */
    public function getEvents(Request $request) {
        $result = new ActionResult();

        $data = $request->all();

        $rules = [
            'from' => 'required|date',
            'to' => 'required|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $events = $this->getBaseEvents($data['from'], $data['to']);
            $birthdays = $this->getBirthdays($data['from'], $data['to']);

            $events = $events->toBase()->merge($birthdays)->all();

            $result->setData('events', $events);
            $result->success('');
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return ActionResult
     */
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

    /**
     * @param Request $request
     * @return ActionResult
     */
    public function update(Request $request)
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
            $event = $this->eventRepository->update($data);

            $result->setData('event', $event);
            $result->success('');
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return ActionResult
     */
    public function remove(Request $request) {
        $result = new ActionResult();

        $eventId = $request->route('event');

        $rules = [
            'eventId' => 'required|exists:event,id',
        ];

        $validator = Validator::make(['eventId' => $eventId], $rules);

        if ($validator->passes()) {
            $this->eventRepository->remove($eventId);

            $result->allOK();
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    private function getBaseEvents($from, $to) {
        return $this->eventRepository->events($from, $to);
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    private function getBirthdays($from, $to) {
        return $this->userRepository
            ->birthdays($from, $to)
            ->map(function ($event) {
                $event['user_id'] = $event['id'];
                $event['duration'] = 1;
                $event['type'] = 'birthday';
                $event['title'] = 'Birthday';
                $event['event_date'] = $event['user_birthday'];
                unset($event['name']);
                unset($event['email']);
                unset($event['user_birthday']);
                return $event;
            }
        );
    }

//    public function remove(Request $request)
//    {
//        $event = Event::find("user_id", $request->id);
//        $event->delete();
//        return $request->id;
//    }
}