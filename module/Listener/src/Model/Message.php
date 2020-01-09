<?php


namespace Listener\Model;


/**
 * Class Message
 *
 * @package Listener\Model
 */
class Message
{
    /**
     * @var string $messanger
     */
    public $messanger;

    /**
     * @var string $identifier
     */
    public $identifier;

    /**
     * @var string $text
     */
    public $text;

    /**
     * @return mixed
     */
    public function getMessanger()
    {
        return $this->messanger;
    }

    /**
     * @param mixed $messanger
     */
    public function setMessanger($messanger)
    {
        $this->messanger = $messanger;
    }


}