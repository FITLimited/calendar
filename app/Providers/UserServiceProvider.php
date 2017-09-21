<?php
namespace App\Providers;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

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