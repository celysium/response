<?php

namespace Celysium\Response;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Celysium\Response\Exceptions\Handler;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'response');


        $this->publishes([
            __DIR__ . '/../config/response.php' => config_path('response.php'),
            __DIR__ . '/../lang/en/response.php' => base_path('lang/en/response.php'),
            __DIR__ . '/../lang/fa/response.php' => base_path('lang/fa/response.php'),
        ], 'response');


        $this->mergeConfigFrom(
            __DIR__ . '/../config/response.php', 'response'
        );
    }

    public function register()
    {
        //
    }
}
