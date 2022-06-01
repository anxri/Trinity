<?php

namespace Trinity;

use Trinity\http\Controller;
use Trinity\database\Mongodb;

class UserController extends Controller
{
    use Mongodb;

    public function __construct()
    {
        $this->init_mongodb();
        $this->collection = $this->database->user;
    }

    public function get_all_user()
    {
        $data = [];
        $cursor = $this->collection->find();

        foreach ( $cursor as $document )
        {
            $data[] = $document;
        }

        return $data;
    }

    public function get_user( $user_id )
    {

    }

    public function post_user()
    {
        $data = file_get_contents("php://input");
        if($data)
        {
            $user = json_decode( $data );
            $this->collection->insertOne( $user );
        }
    }

    public function put_user()
    {

    }

    public function delete_user()
    {

    }
}