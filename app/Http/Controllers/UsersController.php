<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\User;

class UsersController extends Controller
{
    protected $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function index(){
        return User::all();
    }

    public function create(Request $request){
        return $this->user_service->create($request);
    }

    public function remove(Request $request){
        return $this->user_service->remove($request);
    }

}
