<?php

namespace App\Services\User;

use Illuminate\Http\Request;
use App\Services\Event\EventService;
use App\User;

class UserService
{
    protected $event_service;

    public function __construct(EventService $event_service)
    {
        $this->event_service = $event_service;
    }

    public function create(Request $request)
    {
        static $password;

        $user = new User();
        $user->password = $password ?: $password = bcrypt($request->password);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birthday = $request->birthday;
        $user->role = "user";
        $user->remember_token = str_random(10);
        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();

        return $user;
    }

    public function remove(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        //$this->event_service->remove($request);
        return $request->id;
    }
}