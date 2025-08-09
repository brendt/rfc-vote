<?php

namespace App\Providers;

use App\Http\ViewComposers\AdminViewComposer;
use App\Support\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\Browsershot\Browsershot;
use Tempest\Highlight\CommonMark\HighlightExtension;
use Tests\FakeBrowsershot;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MarkdownConverter::class, function () {
            $environment = new Environment;

            $environment
                ->addExtension(new CommonMarkCoreExtension)
                ->addExtension(new HighlightExtension);

            return new MarkdownConverter($environment);
        });

        $this->app->singleton(Meta::class, function () {
            return new Meta(
                title: 'RFC Vote',
                description: 'A community project for voting on PHP RFCs',
                image: url('meta.png'),
            );
        });

        $this->app->singleton(Browsershot::class, function () {
            if (config('services.browsershot.fake')) {
                return new FakeBrowsershot;
            }

            $browsershot = new Browsershot;

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

        View::composer('layouts.base', AdminViewComposer::class);
        View::composer('layouts.admin', AdminViewComposer::class);

        //        Model::preventLazyLoading(! app()->isProduction());
    }
}
