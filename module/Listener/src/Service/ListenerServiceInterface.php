<?php


namespace Test404\Listener\Service;


use Test404\Listener\Model\Message;

interface ListenerServiceInterface
{
    /**
     * @param array $rawData
     *
     * @return Message[]
     */
    public function generateMessages(array $rawData):array ;

    public function prepareData(array $rawData):array ;

    /**
     * @param Message[] $message
     *
     * @return mixed
     */
    public function sendMessages(array $message);
}