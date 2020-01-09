<?php

namespace Listener;

use Listener\Controller\ListenerController;
use Listener\Service\ListenerService;
use Listener\Service\ListenerServiceInterface;
use Listener\Service\ValidatorService;
use Listener\Service\ValidatorServiceInterface;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    // Autoload all classes from namespace 'ListenerController' from '/module/ListenerController/src/ListenerController'
                    __NAMESPACE__ => __DIR__ . '/src/Listener',
                ]
            ]
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                ListenerServiceInterface::class => function($sm) {
                    return new ListenerService();
                },
                ValidatorServiceInterface::class => function($sm) {
                    return new ValidatorService();
                }
            ]
        ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                ListenerController::class => function ($sm) {
                    $listenerService = $sm->get(ListenerServiceInterface::class);
                    $validatorService = $sm->get(ValidatorServiceInterface::class);
                    return new ListenerController($listenerService,$validatorService);
                }
            ]
        ];
    }
}