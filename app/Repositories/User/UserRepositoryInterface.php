<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function create($data);

    public function update($data);

    public function get($userId);

    public function users();

    public function birthdays($from, $to);
}