<?php


namespace Test404\Listener\Factory;


use Exception;
use Test404\Listener\Service\MessangerServiceInterface;
use Zend\ServiceManager\ServiceManager;

class MessangerServiceFactory implements MessangerServiceFactoryInterface
{
    private $serviceManager;
    function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @param string $implementationClassName
     * @return MessangerServiceInterface
     * @throws Exception if class declaration not found
     * @throws Exception if it does not match the type of MessangerServiceInterface
     */
    function create(string $implementationClassName):MessangerServiceInterface
    {
        if (class_exists($implementationClassName)) {

            $messangerService = $this->serviceManager->get($implementationClassName);
            if (!($messangerService instanceof MessangerServiceInterface)) {
                throw new Exception('The instance of the type of "' . $implementationClassName . '" does not implemented the type of MessangerServiceInterface.');
            }
        } else {
            throw new Exception('"' . $implementationClassName . '" class declaration not found.');
        }
        return $messangerService;
    }
}