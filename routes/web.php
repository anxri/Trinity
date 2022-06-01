<?php

global $router;

use \Trinity\exception\HttpException;

$router->get( '/', function(){
    echo '"ROOT"';
});
$router->get( '/hello-world/{name}', 'TestController@welcome');

