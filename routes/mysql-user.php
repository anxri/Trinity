<?php

global $router;


$router->get( '/mysql-user', 'MysqlUserController@get' );

$router->get( '/mysql-user/{email}', 'MysqlUserController@get' );

$router->post( '/mysql-user', 'MysqlUserController@post' );

$router->put( '/mysql-user/{user_id}', 'MysqlUserController@edit' );

$router->delete( '/mysql-user/{user_id}', 'MysqlUserController@delete' );