<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $helperFiles = glob(app_path('Helpers').'/*.php');
        if (is_array($helperFiles)) {
            foreach ($helperFiles as $helperFile) {
                require_once $helperFile;
            }
        }
    }
}
