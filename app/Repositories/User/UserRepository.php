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

    /**
     * @param $data
     * @return User
     */
    public function create($data)
    {
        $user = new User();
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * @param $data
     * @return User
     */
    public function update($data)
    {
        $user = User::find($data['id']);
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function get($userId) {
        return User::query()
                    ->with('role')
                    ->find($userId);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function users() {
        return User::query()
            ->with('role')
            ->whereHas('role', function($query) {
                $query->where('role', UserRole::USER);
            })
            ->get();
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    public function birthdays($from, $to) {
        return User::whereBetween('birthday', [$from, $to])->get();
    }

    /**
     * @param $userId
     */
    public function remove($userId) {
        $user = User::find($userId);

        $user->delete();
    }
}