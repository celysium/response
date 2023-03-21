<?php

namespace Celysium\Responser;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Celysium\Responser\Exceptions\Handler;

class ResponserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'responser');
    }

    public function register()
    {
        //
    }
}
