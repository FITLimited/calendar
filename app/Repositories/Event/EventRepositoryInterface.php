<?php

namespace App\Repositories\Event;

interface EventRepositoryInterface
{
    public function events($from, $to);
}