<?php


namespace Test404\Listener\Controller;

use Exception;
use Test404\Listener\Factory\MessangerServiceFactoryInterface;
use Test404\Listener\Model\Message;
use Test404\Listener\Model\MessageLog;
use Test404\Listener\Service\LoggerServiceInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RuntimeException;
use Zend\Console\Request;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleSenderController extends AbstractActionController
{
    const MAX_ATTEMPTS = 4;

    protected $messangerFactory;

    protected $loggerService;

    public function __construct(
        MessangerServiceFactoryInterface $messangerFactory,
        LoggerServiceInterface $loggerService
    ) {
        $this->messangerFactory = $messangerFactory;
        $this->loggerService    = $loggerService;
    }

    public function shutdown(AMQPChannel $channel, AMQPConnection $connection)
    {
        echo 'Bye' . PHP_EOL;
        $channel->close();
        $connection->close();
    }

    public function messageSendCallback(AMQPMessage $msg)
    {
        try {
            $data = json_decode($msg->body, true);
            $message = new Message($data['messanger'], $data['identifier'],
                $data['text']);
            echo ' [x] Received  message for' . $message->getIdentifier()
                . ' via ' . $message->getMessanger() . ' (try: '
                . $msg->get('priority') . ')' . PHP_EOL;
            if ($msg->get('priority') > self::MAX_ATTEMPTS) {
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                echo ' [!] Maximum retries reached. Message is not sent'
                    . PHP_EOL;
            } else {
                $messageService
                     = $this->messangerFactory->create('Test404\Listener\Service\\'
                    . $message->getMessanger() . 'Service');
                $log = new MessageLog($message);
                if ($messageService->send($message)) {
                    $log->setStatus(0);
                    $this->loggerService->log($log);
                } else {
                    $log->setStatus(4);
                    $this->loggerService->log($log);
                };
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                echo ' [+] Done' . PHP_EOL . PHP_EOL;
            }
        } catch (Exception $ex) {
            $channel = $msg->get('channel');
            $queue   = $msg->delivery_info['routing_key'];
            $new_msg = new AMQPMessage(
                $msg->body,
                array(
                    'delivery_mode' => 1,
                    'priority'      => 1 + $msg->get('priority'),
                    'timestamp'     => time(),
                    'expiration'    => strval(
                        1000 * (strtotime('+1 day midnight') - time() - 1)
                    )
                )
            );
            $channel->basic_publish($new_msg, '', $queue);

            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            echo ' [!] ERROR: ' . $ex->getMessage() . PHP_EOL . PHP_EOL;
        }
    }

    public function senderAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof Request) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        $queue      = 'echo';
        $connection = new AMQPConnection(
            '172.16.0.5',
            5672,
            'guest',
            'guest'
        );
        $channel    = $connection->channel();
        $channel->queue_declare($queue, false, true, false, false);

        echo ' [*] Waiting for messages. To exit press CTRL+C' . PHP_EOL;


        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queue, '', false, false, false, false,
            [$this, 'messageSendCallback']);


        register_shutdown_function([$this, 'shutdown'], $channel, $connection);

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }
}
