<?php


namespace Test404\Listener\Model;


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
     * Message constructor.
     *
     * @param string $messanger
     * @param string $identifier
     * @param string $text
     */
    public function __construct(
        string $messanger,
        string $identifier,
        string $text
    ) {
        $this->messanger = $messanger;
        $this->identifier = $identifier;
        $this->text = $text;
    }

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

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }



}