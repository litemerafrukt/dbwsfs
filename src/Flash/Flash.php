<?php

namespace litemerafrukt\Flash;

use Anax\DI\InjectionAwareInterface;
use Anax\DI\InjectionAwareTrait;

class Flash implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    const FLASH_MESSAGE = "litemerafrukt:flashmessage";
    const FLASH_CLASS   = "litemerafrukt:flashclass";

    private $session;
    private $message;
    private $class;

     /**
     * Init flash object and clear message from session
     */
    public function init()
    {
        $this->session = $this->di->get("session");
        $this->message = $this->session->getOnce(self::FLASH_MESSAGE);
        $this->class = $this->session->getOnce(self::FLASH_CLASS);
    }

    /**
     * Set a flash message available on next request
     *
     * @param string
     * @param string
     */
    public function setFlash($message, $class)
    {
        $this->session->set(self::FLASH_MESSAGE, $message);
        $this->session->set(self::FLASH_CLASS, $class);
    }

     /**
     * Check if there is a message
     *
     * @return bool
     */
    public function hasMessage()
    {
        return $this->message !== null;
    }

    /**
     * Retrieve flash message
     *
     * @return string
     */
    public function message()
    {
        // @codingStandardsIgnoreLine
        return $this->message ?? "";
    }

    /**
     * Retrieve flash message class
     *
     * @return string
     */
    public function class()
    {
        // @codingStandardsIgnoreLine
        return $this->class ?? "";
    }
}
