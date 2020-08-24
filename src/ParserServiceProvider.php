<?php

namespace Ralego\Parser;

use Illuminate\Support\ServiceProvider;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/xmlparser.php', 'xmlparser'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/xmlparser.php' => config_path('xmlparser.php'),
        ], 'laravel-xml-parser');
    }
}
