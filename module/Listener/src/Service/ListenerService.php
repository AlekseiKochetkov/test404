<?php


namespace Listener\Service;


use Listener\Model\Message;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

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

    /**
     * @param Message[] $messages
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function sendMessages(array $messages)
    {
        $queue = 'echo';
        $connection = new AMQPConnection('172.16.0.5', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, true, false, false);

        foreach ($messages as $message) {
            $msg = new AMQPMessage(
                json_encode($message), array(
                    'delivery_mode' => 1,
                    'priority' => 1,
                    'timestamp' => time(),
                    'expiration' => strval(1000 * (strtotime('+1 day midnight') - time() - 1))
                )
            );
            $channel->basic_publish($msg, '', $queue);
            echo ' [>] Message to ' . $message->getIdentifier() . ' via '. $message->getMessanger().' is sent' . PHP_EOL;
        }
        $channel->close();
        $connection->close();

    }
}
