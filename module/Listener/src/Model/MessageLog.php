<?php


namespace Test404\Listener\Model;

class MessageLog extends Message
{
    protected $id;

    public $time;

    public $status;

    /**
     * MessageLog constructor.
     */
    public function __construct(Message $message, int $status = 1)
    {
        $this->text       = $message->getText();
        $this->identifier = $message->getIdentifier();
        $this->messanger  = $message->getMessanger();
        $this->status     = $status;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
