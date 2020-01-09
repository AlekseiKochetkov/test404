<?php

use Listener\Controller\ListenerController;

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

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];