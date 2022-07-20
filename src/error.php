<?php

namespace Trinity\error;

use Trinity\http\Router;

use function Trinity\util\dump;

/**
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 *
 * @return void
 */
function error_handler($errno, $errstr, $errfile, $errline ): void
{
    Router::silent_shutdown();

    global $config, $response;

    $response->set_status_code( 500 );

    if( $config['DEFAULT_CONTENT_TYPE'] === 'plain' )
    {
        exit("#$errno $errfile($errline): $errstr");
    }
    elseif( $config['DEFAULT_CONTENT_TYPE'] === 'html' )
    {
        exit('{"error":{
            "code":"'.$errno.'",
            "message":"'.$errstr.'",
            "file":"'.$errfile.'",
            "line":"'.$errline.'"}}');
    }
    else
    {
        exit('{"error":{
            "code":"'.$errno.'",
            "message":"'.$errstr.'",
            "file":"'.$errfile.'",
            "line":"'.$errline.'"}}');
    }
}

/**
 * @param Throwable $exception
 *
 * @return void
 */
function exception_handler( \Throwable $e ): void
{
    Router::silent_shutdown();

    global $config, $response;

    $response->set_status_code( 500 );

    if( $config['DEFAULT_CONTENT_TYPE'] === 'plain' )
    {
        echo $e->getTraceAsString();
    }
    elseif( $config['DEFAULT_CONTENT_TYPE'] === 'html' )
    {
        echo $e->getTraceAsString();
    }
    else
    {
        static $exceptions;

        // output single exception
        if( !$e->getPrevious() && gettype($exceptions) !== 'array' )
        {
            echo '{"error":[{
            "code":"'.$e->getCode().'",
            "message":"'.$e->getMessage().'",
            "file":"'.$e->getFile().'",
            "line":"'.$e->getLine().'"}]}';

        }

        // store exception information in static variable
        $exceptions[] = json_decode( '{
            "code":"'.$e->getCode().'",
            "message":"'.$e->getMessage().'",
            "file":"'.$e->getFile().'",
            "line":"'.$e->getLine().'"}' );

        // recursive call
        if( $e->getPrevious() )
        {
            exception_handler( $e->getPrevious() );
        }

        // output multiple exceptions
        if( !$e->getPrevious() && gettype($exceptions) === 'array' && sizeof( $exceptions ) > 1 )
        {
            echo '{"error":';
            echo json_encode( $exceptions );
            echo '}';
        }
    }
}

