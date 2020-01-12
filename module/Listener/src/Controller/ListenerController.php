<?php

namespace Listener\Controller;

use Listener\Model\MessageLog;
use Listener\Service\ListenerServiceInterface;
use Listener\Service\LoggerServiceInterface;
use Listener\Service\ValidatorServiceInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Exception;

class ListenerController extends AbstractRestfulController
{
    /**
     * @var ListenerServiceInterface $listenerService
     */
    protected $listenerService;

    /**
     * @var ValidatorServiceInterface $validatorService
     */
    protected $validatorService;

    /**
     * @var LoggerServiceInterface $loggerService
     */
    protected $loggerService;

    public function __construct(
        ListenerServiceInterface $listenerService,
        ValidatorServiceInterface $validatorService,
        LoggerServiceInterface $loggerService
    ) {
        $this->listenerService  = $listenerService;
        $this->validatorService = $validatorService;
        $this->loggerService    = $loggerService;
    }

    public function indexAction()
    {
        return new JsonModel(["test"]);
    }

    public function sendAction()
    {
        try {
            $data    = [];
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = $this->processBodyContent($request);
            }
            $data = $this->listenerService->prepareData($data);
            if (!$this->validatorService->validateRequestData((array)$data)) {
                return new JsonModel(["No data in request", (array)$data]);
            }

            //ToDo: fields validation here(based on messanger?)
            $messages = $this->listenerService->generateMessages($data);

            foreach ($messages as $key => $message) {
                if (!$this->loggerService->checkLog($message)) {
                    unset($messages[$key]);
                    continue;
                }
                $log = new MessageLog($message);
                $this->loggerService->log($log);
                if (!$this->validatorService->validateMessageFields($message)) {
                    $log->setStatus(2);
                    $this->loggerService->log($log);
                    unset($messages[$key]);
                }
            }
            //ToDo: send messages
            $this->listenerService->sendMessages($messages);
            foreach ($messages as $key => $message) {
                $log = new MessageLog($message, 3);
                $this->loggerService->log($log);
            }
            return new JsonModel();
        } catch (Exception $e) {
            return new JsonModel(
                [
                    'result'  => 'Message sending failed',
                    'message' => $e->getMessage()
                ]
            );
        }
    }
}
