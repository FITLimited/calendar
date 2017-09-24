<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function create($data);

    public function get($userId);

    public function users();
}