<?php

namespace Blog\Providers;

use Blog\Repositories\CategoryRepository;
use Blog\Repositories\DataSource\CategoryEloquentDataSource;
use Blog\Repositories\DataSource\PostEloquentDataSource;
use Blog\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/blog.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Repositories
        $this->app->singleton(CategoryRepository::class, CategoryEloquentDataSource::class);
        $this->app->singleton(PostRepository::class, PostEloquentDataSource::class);
    }

}
