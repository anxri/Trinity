<?php

namespace Trinity;

use Trinity\http\Controller;

class TestController extends Controller
{
    public function welcome( $name )
    {
        echo "\"Welcome to Trinity, $name! :)\"";
    }
}