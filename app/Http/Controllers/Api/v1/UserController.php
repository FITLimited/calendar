<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

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

    public function updateUser(Request $request){
        $result = $this->userService->update($request);

        return $this->apiResponse($result);
    }

    public function removeUser(Request $request){
        $result = $this->userService->remove($request);

        return $this->apiResponse($result);
    }
}
