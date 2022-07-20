<?php

namespace Trinity;

use Trinity\util\Autoloader;
use Trinity\http\Request;
use Trinity\http\Response;
use Trinity\http\Router;
use Trinity\util\Log;

/**
 * @return void
 * @throws \Exception
 */
function app_init(): void
{
    set_error_handler("Trinity\\error\\error_handler");
    set_exception_handler("Trinity\\error\\exception_handler");

    global
        $config,
        $error_log,
        $request,
        $response,
        $router;

    $config = ini_load();
    $error_log = new Log( '/var/www/trinity/logs/error.log', 0 );
    $request = new Request();
    $response = new Response();
    $router = new Router( [ 'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS' ] );

    //$response->get_header_value( 'Access-Control-Allow-Origin', 'null' );

    //header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept' );
    //header( 'Access-Control-Allow-Methods: GET, POST, PUT' );
    //header( 'Access-Control-Allow-Headers: Content-Type' );
}


/**
 * @return void
 */
function app_run(): void
{
    // load routes separately so that all objects can be initialized properly
    $autoloader = new Autoloader(); // trinity only autoloader
    $autoloader->add_directory( 'routes' );
    $autoloader->autoload();
}
