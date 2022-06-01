<?php

namespace Trinity;

use Trinity\HTTP\Middleware;

class ExampleMiddleware extends Middleware
{
    public static function handle()
    {
        echo "test middlware!\n";
    }
}