<?php

namespace App\Providers;

use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;
use App\Services\LoggerService;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Model;
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
        $this->app->bind(PostRepository::class, function ($app) {
            return new PostRepository(new Post());
        });

        $this->app->bind(LoggerService::class, function ($app) {
            return new LoggerService();
        });

        $this->app->bind(PostService::class, function ($app) {
            return new PostService($app->make(PostRepository::class), $app->make(LoggerService::class));
        });
    }
}
