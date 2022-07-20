<?php

namespace Noxx\Trinity\database;

use PDO as PDO_Class;

trait Pdo
{
    public $pdo;

    public function init_pdo()
    {
        global $config;

        $this->pdo = new PDO_Class(
            $config['PDO_DRIVER'] . ':host=' . $config['PDO_HOST'] . ';dbname=' . $config['PDO_DATABASE'],
            $config['PDO_USER'],
            $config['PDO_PASS']
        );

        $this->pdo->setAttribute( PDO_Class::ATTR_ERRMODE, PDO_Class::ERRMODE_EXCEPTION );
    }
}