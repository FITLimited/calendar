<?php

namespace App\Http\Controllers\api\v1;

use App;
use Illuminate\Http\Request;

use App\Services\UserService;
use App\Http\Controllers\BaseApiController;

class AccountController extends BaseApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(Request $request)
    {
        $result = $this->userService->getUser($request);

        return $this->apiResponse($result);
    }

//    public function updateUser(Request $request) {
//        $data = $request->all();
//        $userId = $request->user()->id;
//
//        $result = $this->userService->updateUser($userId, $data);
//
//        return $this->apiResponse($result);
//    }
//
//    public function updatePassword(Request $request) {
//        $data = $request->all();
//        $userId = $request->user()->id;
//
//        $result = $this->userService->updatePassword($userId, $data);
//
//        return $this->apiResponse($result);
//    }
}
