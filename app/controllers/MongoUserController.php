<?php

namespace Trinity;

use Trinity\http\Controller;
use Trinity\database\Mongodb;

class MongoUserController extends Controller
{
    use Mongodb;

    /**
     *
     */
    public function __construct()
    {
        $this->init_mongodb();

        $this->collection = $this->database->user;
    }

    /**
     * @param $email
     *
     * @return array
     */
    public function get( $email = NULL )
    {
        if ( $email !== NULL )
        {
            $data = [];
            $cursor = $this->user->find( [ 'email' => $email ] );

            foreach( $cursor as $document )
            {
                $data[] = $document;
            }
        }
        else
        {
            $data = [];
            $cursor = $this->user->findAll();

            foreach( $cursor as $document )
            {
                $data[] = $document;
            }
        }

        return $data;
    }

    /**
     * @return void
     */
    public function post()
    {
        global $request;
        $data = $request->get_body();

        if ( $data )
        {
            $user = json_decode( $data );
            $this->user->insertOne( $user );
        }
    }

    /**
     * @param $user_id
     *
     * @return void
     */
    public function put( $user_id )
    {
        global $request;
        $data = $request->get_body();

        $this->user->updateOne(
            [ 'user_id' => $user_id ],
            [ '$set' => $data ]
        );
    }

    /**
     * @param $user_id
     *
     * @return \MongoDB\DeleteResult
     */
    public function delete( $user_id )
    {
        return $this->user->deleteOne( [ 'user_id' => $user_id ] );
    }
}