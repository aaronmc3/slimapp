<?php
return [
    'slim' => [
        'settings' => [
            // Enable whoops
            'debug' => true,
            // Support click to open editor
            'whoops.editor' => 'sublime',
            // Display call stack in orignal slim error when debug is off
            'displayErrorDetails' => true,

            'determineRouteBeforeAppMiddleware' => false,
            'displayErrorDetails' => true,
    
            'db' => [

                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'slimapp',
                'username' => 'root',
                'password' => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',

            ]

        ],
    
    ],
    
];