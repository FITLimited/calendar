<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\User;
use App\Services\UserService;

class UsersController extends BaseApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
//
//    public function index(){
//        return User::all();
//    }

    public function login(Request $request){
        $result = $this->userService->login($request);

        return $this->apiResponse($result);
    }

    public function remove(Request $request){
        return $this->userService->remove($request);
    }

}
