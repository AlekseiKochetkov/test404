<?php


namespace Listener\Service;


use Listener\Model\Message;
use Listener\Model\MessageLog;
use Listener\Persistence\LogRepositoryInterface;
use Zend\Db\Adapter\Driver\Pdo\Result;

class LoggerService implements LoggerServiceInterface
{
    protected $logRepository;
    /**
     * LoggerService constructor.
     */
    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function checkLog(Message $message): bool
    {
        /**
         * @var Result $result
         */
        $result = $this->logRepository->fetch(
            [
            'text'       => $message->getText(),
            'identifier' => $message->getIdentifier(),
            'status'     => 0
            ]
        );
        var_dump($result->count());
        if($result->count()>0){
            return false;
        }
        return true;
    }

    public function log(MessageLog $log)
    {
        $this->logRepository->insert($log);
    }


}
