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
    '/api/users/logined@post'                => [
        'target'     => 'UserController@Logined',
        'middleware' => ''
    ],
    '/api/post/add@post'                => [
        'target'     => 'PostController@add',
        'middleware' => 'true'
    ],
    '/api/post/edit@post'                => [
        'target'     => 'PostController@edit',
        'middleware' => 'true'
    ],
    '/api/post/del@post'                => [
        'target'     => 'PostController@del',
        'middleware' => 'true'
    ],
];