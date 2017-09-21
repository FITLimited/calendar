<?php

namespace App\Http\Controllers;

use App\Helpers\ActionResult;

class BaseApiController extends Controller
{
    protected function apiResponse(ActionResult $answer)
    {
        return response()->json($answer->toArray());
    }
}