<?php


namespace Listener\Service;


interface ValidatorServiceInterface
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function validateRequestData(array $data):bool;

}