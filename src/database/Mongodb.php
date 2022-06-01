<?php

namespace Trinity\database;

use MongoDB\Client;

trait Mongodb
{
    private $connection_str = 'mongodb://localhost:27017';
    private $database_name = 'trinity';

    public $client;
    public $database;
    public $collection;

    public function init_mongodb()
    {
        $this->client = new Client();
        $this->database = $this->client->trinity;
    }
}