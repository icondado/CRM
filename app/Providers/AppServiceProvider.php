<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Model;


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
    public function boot()
    {
        Paginator::useBootstrap();
        $modelPath = app_path('Models');
        $namespace = 'App\\Models\\';

        foreach (File::allFiles($modelPath) as $file) {
            $class = $namespace . $file->getFilenameWithoutExtension();

            if (
                class_exists($class) &&
                is_subclass_of($class, Model::class) &&
                $class !== \App\Models\Log::class
            ) {
                $class::observe(GlobalObserver::class);
            }
        }
    }
}
