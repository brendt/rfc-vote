<?php

namespace App\Providers;

use App\Support\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Spatie\Browsershot\Browsershot;
use Tests\FakeBrowsershot;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Meta::class, function () {
            return new Meta(
                title: "RFC Vote",
                description: "RFC Vote",
                image: url('meta.png'),
            );
        });

        $this->app->singleton(Browsershot::class, function () {
            if (config('services.browsershot.fake')) {
                return new FakeBrowsershot();
            }

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
    }
}
