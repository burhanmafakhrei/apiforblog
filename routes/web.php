<?php
return [
    '/api/users/add@post'                => [
        'target'     => 'UserController@add',
        'middleware' => ''
    ],
    '/api/users/login@post'                => [
        'target'     => 'UserController@login',
        'middleware' => ''
    ],
    '/api/users/Logined@post'                => [
        'target'     => 'UserController@Logined',
        'middleware' => ''
    ],

];