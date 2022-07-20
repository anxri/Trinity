<?php

global $router;

$router->get( '/', function ()
{
    echo '"ROOT"';
} );

$router->get( '/hello-world/{name}', 'TestController@welcome' );

