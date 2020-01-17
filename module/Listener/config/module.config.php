<?php

use Test404\Listener\Controller\ListenerController;
use Test404\Listener\Controller\ConsoleSenderController;

return [
    'router' => [
        'routes' => [
            'listener' => [
                'type'    => 'Segment',
                'options' => [
                    'route'       => '/[:action]',
                    'defaults'    => [
                        'controller' => ListenerController::class,
                        '__NAMESPACE__' => 'Test404\Listener\Controller',
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
                            '__NAMESPACE__' => 'Test404\Listener\Controller',
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