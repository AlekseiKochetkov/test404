<?php


namespace Listener\Factory;


use Listener\Service\MessangerServiceInterface;

interface MessangerServiceFactoryInterface
{
    /**
     * @param string $implementationClassName
     * @return MessangerServiceInterface
     */
    function create(string $implementationClassName):MessangerServiceInterface;
}