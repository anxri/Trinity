<?php

namespace Trinity;

use Trinity\http\Controller;
use Trinity\http\Response;

class TestController extends Controller
{
    public function welcome( $name )
    {
        echo "\"Welcome to a new Framework, $name! :)\"";

        $response           = new Response();

        $response->get_header();
    }
}