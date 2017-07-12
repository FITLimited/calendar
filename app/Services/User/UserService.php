<?php
namespace App\Services\User;
use Illuminate\Http\Request;
use App\User;

class UserService
{

    public function create(Request $request)
    {
        static $password;

        $user = new User();
        $user->password = $password ?: $password = bcrypt($request->password);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = "user";
        $user->remember_token = str_random(10);
        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();

        return $user;
    }
}