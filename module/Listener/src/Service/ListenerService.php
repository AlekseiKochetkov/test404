<?php


namespace Listener\Service;


use Listener\Model\Message;

class ListenerService implements ListenerServiceInterface
{
    /**
     * @param array $rawData
     *
     * @return Message[]
     */
    public function generateMessages(array $rawData):array
    {
        $messages = [];
        foreach ($rawData['destination'] as $destination) {
            $messages []= new Message($destination['messanger'], $destination['identifier'], $rawData['text']);
        }
        return $messages;
    }

    public function prepareData(array $rawData):array
    {
        if (!is_array($rawData['destination'])) {
            $rawData['destination'] = [$$rawData['destination']];
        }
        return $rawData;
    }
}
