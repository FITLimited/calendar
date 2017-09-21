<?php

namespace App\Http\Controllers\Api\v1;

use App;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseApiController;
use App\Services\UserService;

class AuthController extends BaseApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $result = $this->userService->login($request);

        return $this->apiResponse($result);
    }

    public function register(Request $request)
    {
        $result = $this->userService->create($request);

        return $this->apiResponse($result);
    }
}