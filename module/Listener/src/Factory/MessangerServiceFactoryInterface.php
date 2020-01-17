<?php


namespace Test404\Listener\Factory;


use Test404\Listener\Service\MessangerServiceInterface;

interface MessangerServiceFactoryInterface
{
    /**
     * @param string $implementationClassName
     * @return MessangerServiceInterface
     */
    function create(string $implementationClassName):MessangerServiceInterface;
}