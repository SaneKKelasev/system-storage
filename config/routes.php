<?php

$urlList = [
    [
        '' => [
            'GET' => 'HomepageController::view'
        ]
    ],
    [
        'funds' => [
            'GET' => 'FundsController::list',
            'POST' => 'FundsController::add'
        ]
    ],
    [
        'user' => [
            'GET' => 'UserController::list',
            'POST' => 'UserController::add',
            'PUT' => 'UserController::update',
            'DELETE' => 'UserController::delete',
        ]
    ],
    [
        'login' => [
            'GET' => 'UserController::login',
        ]
    ],
    [
        'logout' => [
            'GET' => 'UserController::logout',
        ]
    ],
    [
        'reset_password' => [
            'GET' => 'UserController::resetPassword',
        ]
    ],
];
