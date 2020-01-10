<?php

use Listener\Controller\ListenerController;
use Listener\Controller\ConsoleSenderController;

return [
    'router' => [
        'routes' => [
            'listener' => [
                'type'    => 'Segment',
                'options' => [
                    'route'       => '/listener[/:action]',
                    'defaults'    => [
                        'controller' => ListenerController::class,
                        '__NAMESPACE__' => 'Listener\Controller',
                        'action'     => 'index',
                    ],
                ],
            ],
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'message-sender' => [
                    'type'    => 'simple',
                    'options' => [
                        'route' => 'message-sender',
                        'defaults' => [
                            'controller'    => ConsoleSenderController::class,
                            '__NAMESPACE__' => 'Listener\Controller',
                            'action'        => 'sender'
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];