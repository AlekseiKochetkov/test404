<?php


namespace Listener\Service;


use Listener\Model\Message;
use Listener\Model\MessageLog;
use Listener\Persistence\LogRepositoryInterface;

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
        $result = $this->logRepository->fetch(
            [
            'text'=>$message->getText(),
            'identifier'=>$message->getIdentifier()
            ]
        );
        return !empty($result);
    }

    public function log(MessageLog $log)
    {
        $this->logRepository->insert($log);
    }


}
