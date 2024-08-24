<?php

namespace App\Providers;

use App\Repositories\DepartmentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\RepositoryInterface;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, UserRepository::class);
        $this->app->bind(RepositoryInterface::class, StudentRepository::class);
        $this->app->bind(RepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(RepositoryInterface::class, SubjectRepository::class);

        require_once app_path('Http/Helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
