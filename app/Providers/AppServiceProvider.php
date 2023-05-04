<?php

namespace App\Providers;

use App\Http\Livewire\DataTable;
use App\Http\Livewire\PostTable;
use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;
use App\Services\LoggerService;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\View\Component\Sort;

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
        Livewire::component('post-table', PostTable::class);
        Livewire::component('data-table', DataTable::class);

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
