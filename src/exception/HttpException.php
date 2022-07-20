<?php

namespace Trinity\exception;

class HttpException extends BaseException
{
    /**
     * @param $message
     * @param $code
     */
    public function __construct( $message, $code = 500, ?Throwable $previous = null  )
    {
        global $config;
        parent::__construct( $message, $code, $previous );

        if( $config['DEFAULT_CONTENT_TYPE'] === 'plain' )
        {
            $this->get_plain_error_msg( $message );
        }
        elseif( $config['DEFAULT_CONTENT_TYPE'] === 'html' )
        {
            $this->get_html_error_msg( $message );
        }
        elseif( $config['DEFAULT_CONTENT_TYPE'] === 'json' )
        {
            $this->get_json_error_msg( $message );
        }
    }

    /**
     * @param $message
     *
     * @return void
     */
    private function get_plain_error_msg( $message )
    {
        echo "$message";
    }

    /**
     * @param $message
     *
     * @return void
     */
    private function get_html_error_msg( $message )
    {
        echo "$message";
    }

    /**
     * @param $message
     *
     * @return void
     */
    private function get_json_error_msg( $message )
    {
        echo "{\"error\":[\"$message\"]}";
    }
}