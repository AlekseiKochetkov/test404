<?php


namespace Test404\Listener\Service;


use Test404\Listener\Model\Message;

interface ValidatorServiceInterface
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function validateRequestData(array $data):bool;

    public  function validateMessageFields(Message $message):bool;

}