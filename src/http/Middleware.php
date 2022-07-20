<?php

namespace Trinity\http;

use Trinity\Router;

abstract class Middleware
{
    public function __construct(){}

    public function __get( $name )
    {
        if ( $name === 'router' )
        {
            $router = new Router( get_called_class() );
            return $router;
        }
    }

    abstract static public function handle();
}