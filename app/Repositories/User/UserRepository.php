<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function create($data)
    {
        $user = new User();
        $user->fill($data);
        $user->save();

        return $user;
    }
}