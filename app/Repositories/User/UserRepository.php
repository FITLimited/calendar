<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserRole;

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

    public function get($userId) {
        return User::query()
                    ->with('role')
                    ->find($userId);
    }

    public function users() {
        return User::query()
            ->with('role')
            ->whereHas('role', function($query) {
                $query->where('role', UserRole::USER);
            })
            ->get();
    }
}