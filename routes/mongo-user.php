<?php

global $router;


$router->get( '/mongo-user', 'MongoUserController@get' );

$router->get( '/mongo-user/{email}', 'MongoUserController@get' );

$router->post( '/mongo-user', 'MongoUserController@post_user' );

$router->put( '/mongo-user/{user_id}', 'MongoUserController@edit_user' );

$router->delete( '/mongo-user/{user_id}', 'MongoUserController@delete_user' );
