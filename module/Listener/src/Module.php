<?php

namespace Test404\Listener;

use Test404\Listener\Controller\ConsoleSenderController;
use Test404\Listener\Controller\ListenerController;
use Test404\Listener\Factory\MessangerServiceFactory;
use Test404\Listener\Factory\MessangerServiceFactoryInterface;
use Test404\Listener\Persistence\LogRepository;
use Test404\Listener\Persistence\LogRepositoryInterface;
use Test404\Listener\Persistence\Repository;
use Test404\Listener\Persistence\RepositoryInterface;
use Test404\Listener\Service\ListenerService;
use Test404\Listener\Service\ListenerServiceInterface;
use Test404\Listener\Service\LoggerService;
use Test404\Listener\Service\LoggerServiceInterface;
use Test404\Listener\Service\TelegramService;
use Test404\Listener\Service\ValidatorService;
use Test404\Listener\Service\ValidatorServiceInterface;
use Test404\Listener\Service\ViberService;
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
                    // Autoload all classes from namespace Test404\'ListenerController' from '/module/ListenerController/src/ListenerController'
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
