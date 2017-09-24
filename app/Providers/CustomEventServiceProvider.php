<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Event;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;

class CustomEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind(EventRepositoryInterface::class, function() {
            return new EventRepository(new Event());
        });
    }
}