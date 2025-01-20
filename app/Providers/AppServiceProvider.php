<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\IncomingLetterRepositoryInterface;
use App\Repositories\Contracts\OutgoingLetterRepositoryInterface;
use App\Repositories\Contracts\PartyRepositoryInterface;
use App\Repositories\Contracts\RolePermissionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\IncomingLetterRepository;
use App\Repositories\OutgoingLetterRepository;
use App\Repositories\PartyRepository;
use App\Repositories\RolePermissionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RolePermissionRepositoryInterface::class, RolePermissionRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PartyRepositoryInterface::class, PartyRepository::class);
        $this->app->bind(IncomingLetterRepositoryInterface::class, IncomingLetterRepository::class);
        $this->app->bind(OutgoingLetterRepositoryInterface::class, OutgoingLetterRepository::class);
    }
}
