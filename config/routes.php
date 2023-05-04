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
        'user/search' => [
            'GET' => 'UserController::search',
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
    [
        'admin/user' => [
            'GET' => 'Admin\UserController::list',
            'DELETE' => 'Admin\UserController::delete',
            'PUT' => 'Admin\UserController::update',
        ]
    ],
    [
        'file' => [
            'GET' => 'FileController::list',
            'POST' => 'FileController::add',
            'PUT' => 'FileController::update',
            'DELETE' => 'FileController::delete',
        ]
    ],
    [
        'files/share' => [
            'GET' => 'FileController::getShare',
            'PUT' => 'FileController::addShare',
            'DELETE' => 'FileController::deleteShare',
        ]
    ],
    [
        'directory' => [
            'GET' => 'DirectoryController::list',
            'POST' => 'DirectoryController::add',
            'PUT' => 'DirectoryController::update',
            'DELETE' => 'DirectoryController::delete',
        ]
    ],
];
