<?php

namespace App\Http\Controllers;

class PhpInfoController
{
    public function __invoke()
    {
        phpinfo();
        exit;
    }
}
