<?php

global $router;

$router->get( '/user', 'UserController@get_all_user' );
$router->get( '/user/{$email}','UserController@get_user' );
$router->post( '/user','UserController@post_user' );
$router->put( '/user/{$user_id}','UserController@edit_user' );
$router->delete( '/user/{$user_id}','UserController@delete_user' );