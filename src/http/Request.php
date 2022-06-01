<?php

namespace Trinity\http;

use Trinity\util\Log;

require_once 'src/util/Singleton.php';

class Request
{
    private array $header;
    private string $body;

    /**
     * @throws \Exception
     */
    public function __construct()
    {

        $this->header = getallheaders();
        $this->body = file_get_contents('php://input');
    }

    /**
     * @return array|false
     */
    public function get_header()
    {
        return $this->header;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get_header_value( string $key )
    {
        if( in_array( $key, $this->header ))
        {
            return $this->header[$key];
        }
        else
        {
            return NULL;
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function set_header_value( string $key, string $value )
    {
        $this->header[$key] = $value;
    }

    /**
     * @return false|string
     */
    public function get_body()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return void
     */
    public function set_body( string $body )
    {
        $this->body = $body;
    }
}