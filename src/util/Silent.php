<?php

namespace Trinity\util;

/**
 * Class Silent
 *
 * @package ANXRI\api-framework
 */
abstract class Silent
{
    /**
     * Silent constructor.
     */
    public function __construct()
    {
        ob_start();
    }

    /**
     *
     */
    final public function __destruct()
    {
        ob_end_clean();
    }

    /**
     * @param $name
     *
     * @return null
     */
    public function __get( $name )
    {
        return NULL;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set( $name, $value ){}
}
