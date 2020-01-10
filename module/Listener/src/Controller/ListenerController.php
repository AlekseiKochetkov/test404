<?php

namespace Listener\Controller;

use Listener\Service\ListenerServiceInterface;
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

    public function __construct(
        ListenerServiceInterface $listenerService,
        ValidatorServiceInterface $validatorService
    ) {
        $this->listenerService  = $listenerService;
        $this->validatorService = $validatorService;
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

            //ToDo: send messages
            $this->listenerService->sendMessages($messages);
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
