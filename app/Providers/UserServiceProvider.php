<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

class UserServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, function() {
            return new UserRepository(new User());
        });
    }
}