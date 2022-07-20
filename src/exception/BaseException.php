<?php

namespace Trinity\exception;

use Throwable;

class BaseException extends \Exception
{

    /**
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct( $message, $code, ?Throwable $previous = null )
    {
        global $error_log;
        $error_log->error( "In " . __CLASS__ . "::" . __FUNCTION__ . " [$code] - $message" );

    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}