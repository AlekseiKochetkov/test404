<?php


namespace Test404\Listener\Service;


use Test404\Listener\Model\Message;
use Test404\Listener\Model\MessageLog;
use Test404\Listener\Persistence\LogRepositoryInterface;
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
