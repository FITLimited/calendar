<?php

namespace App\Repositories\Event;

interface EventRepositoryInterface
{
    public function events($from, $to);

    public function create($data);

    public function update($data);
}