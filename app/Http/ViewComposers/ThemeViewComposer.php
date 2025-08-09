<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ThemeViewComposer
{
    public function compose(View $view): void
    {
        $theme = request()->cookies->get('theme');

        $themeCssClass = match ($theme) {
            'dark', 'system-dark' => 'dark',
            'light', 'system-light' => 'light',
            default => '',
        };

        $view->with('themeCssClass', $themeCssClass);
    }
}
