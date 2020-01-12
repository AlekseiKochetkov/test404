<?php

namespace Listener;

use Listener\Controller\ConsoleSenderController;
use Listener\Controller\ListenerController;
use Listener\Factory\MessangerServiceFactory;
use Listener\Factory\MessangerServiceFactoryInterface;
use Listener\Persistence\LogRepository;
use Listener\Persistence\LogRepositoryInterface;
use Listener\Persistence\Repository;
use Listener\Persistence\RepositoryInterface;
use Listener\Service\ListenerService;
use Listener\Service\ListenerServiceInterface;
use Listener\Service\LoggerService;
use Listener\Service\LoggerServiceInterface;
use Listener\Service\TelegramService;
use Listener\Service\ValidatorService;
use Listener\Service\ValidatorServiceInterface;
use Listener\Service\ViberService;
use Zend\ServiceManager\ServiceManager;

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
                ListenerServiceInterface::class         => function (
                    ServiceManager $sm
                ) {
                    return new ListenerService();
                },
                ValidatorServiceInterface::class        => function (
                    ServiceManager $sm
                ) {
                    return new ValidatorService();
                },
                LoggerServiceInterface::class           => function (
                    ServiceManager $sm
                ) {
                    $logRepository = $sm->get(LogRepositoryInterface::class);
                    return new LoggerService($logRepository);
                },
                MessangerServiceFactoryInterface::class => function (
                    ServiceManager $sm
                ) {
                    return new MessangerServiceFactory($sm);
                },
                TelegramService::class                  => function (
                    ServiceManager $sm
                ) {
                    return new TelegramService();
                },
                ViberService::class                     => function (
                    ServiceManager $sm
                ) {
                    return new ViberService();
                },
                RepositoryInterface::class              => function (
                    ServiceManager $sm
                ) {
                    return new Repository();
                },
                LogRepositoryInterface::class           => function (
                    ServiceManager $sm
                ) {
                    return new LogRepository();
                },
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                ListenerController::class      => function (ServiceManager $sm) {
                    $listenerService  = $sm->get(ListenerServiceInterface::class);
                    $validatorService = $sm->get(ValidatorServiceInterface::class);
                    $loggerService    = $sm->get(LoggerServiceInterface::class);
                    return new ListenerController(
                        $listenerService,
                        $validatorService,
                        $loggerService
                    );
                },
                ConsoleSenderController::class => function (ServiceManager $sm) {
                    $messageServiceFactory = $sm->get(MessangerServiceFactoryInterface::class);
                    $loggerService         = $sm->get(LoggerServiceInterface::class);
                    return new ConsoleSenderController(
                        $messageServiceFactory,
                        $loggerService
                    );
                }
            ]
        ];
    }
}
