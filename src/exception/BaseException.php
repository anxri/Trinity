<?php

namespace Trinity\exception;

class BaseException extends \Exception
{
    public function __construct( $message, $code, $previous=NULL )
    {
        global $error_log;
        $error_log->error( "In " . __CLASS__ . "::" . __FUNCTION__ . " [$code] - $message" );
    }
}