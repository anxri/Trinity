<?php

namespace Trinity\exception;

class HttpException extends BaseException
{
    public function __construct($message, $code=500)
    {
        global $router;
        $router->disable();
        parent::__construct($message, $code, NULL);
        $this->get_json_error_msg($message);
        exit(0);
    }

    private function get_plain_error_msg()
    {

    }

    private function get_html_error_msg()
    {

    }

    private function get_json_error_msg($message)
    {
        echo "{\"error\":[\"$message\"]}";
    }
}