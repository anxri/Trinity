<?php

namespace Trinity\database;

use MongoDB\Client;

trait Mongodb
{
    public function init_mongodb()
    {
        global $config;
        $this->client = new Client( 'mongodb://' . $config['MONGODB_HOST'] . ':' . $config['MONGODB_PORT'] );
        $this->database = $this->client->{$config['PDO_DATABASE']};
    }
}