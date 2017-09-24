<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\UserService;
use App\Http\Controllers\BaseApiController;

class UserController extends BaseApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUsers(){
        $result = $this->userService->getUsers();

        return $this->apiResponse($result);
    }

//    public function remove(Request $request){
//        return $this->userService->remove($request);
//    }

}
