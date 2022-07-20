<?php

namespace Trinity\http;

class Response
{
    private int $status_code;

    /**
     *
     */
    public function __construct()
    {
        global $config;

        if ( $config['DEFAULT_CONTENT_TYPE'] === 'plain' )
        {
            $this->get_header_value( 'Content-Type', 'text/plain' );
        }
        else if ( $config['DEFAULT_CONTENT_TYPE'] === 'html' )
        {
            $this->get_header_value( 'Content-Type', 'text/html' );
        }
        else if ( $config['DEFAULT_CONTENT_TYPE'] === 'json' )
        {
            $this->get_header_value( 'Content-Type', 'application/json' );
        }
    }

    /**
     * @param $code
     *
     * @return void
     */
    public function set_status_code( $code )
    {
        $this->status_code = $code;
        http_response_code( $this->status_code );
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function get_header_value( string $name, string $value )
    {
        header( $name . ': ' . $value );
    }

    /**
     * @return array
     */
    public function get_header()
    {
        return headers_list();
    }
}