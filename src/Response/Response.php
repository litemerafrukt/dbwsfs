<?php

namespace litemerafrukt\Response;

use \Anax\Response\ResponseUtility;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * Handling a response and includes utilitie methods.
 */
class Response extends ResponseUtility implements
    InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Redirect to previous page. Root as fallback.
     *
     * @return void
     */
    public function redirectPrevious()
    {
        $httpRefererOrHome = $this->di->get('previousRoute');
        $previousRouteOrHome = \explode("?", $httpRefererOrHome)[0];

        $this->redirect($previousRouteOrHome);
    }
}
