<?php

declare( strict_types=1 );

namespace Trinity\Util;

use Exception;

class Singleton
{
    protected object|null $_instance = NULL;

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public final function get_instance()
    {
        $class = get_called_class();
        if ( !isset( $this->_instance ) )
        {
            $this->_instance = new $class();
        }
        return $this->_instance;
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    protected function __construct(){}

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone(){}

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    public function __wakeup()
    {
        throw new Exception( "Cannot unserialize singleton" );
    }
}