<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $helperFiles = glob(app_path('Helpers').'/*.php');
        foreach ($helperFiles as $helperFile) {
            require_once $helperFile;
        }
    }
}
