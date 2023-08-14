<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use Spatie\Browsershot\Browsershot;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Browsershot::class, function () {
            $browsershot = new Browsershot();

            if ($chromePath = config('services.browsershot.chrome_path')) {
                $browsershot->setChromePath($chromePath);
            }

            if ($nodePath = config('services.browsershot.node_path')) {
                $browsershot->setNodeBinary($nodePath);
            }

            if ($npmPath = config('services.browsershot.npm_path')) {
                $browsershot->setNpmBinary($npmPath);
            }

            return $browsershot;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Horizon::auth(function (Request $request) {
            return $request->user()?->is_admin;
        });
    }
}
