<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;

class LayoutController extends InjectionAwareClass
{
    private $loginButton;
    private $pageMenu;
    private $aside;

    public function __construct($loginButton, $pageMenu, $aside)
    {
        $this->loginButton = $loginButton;
        $this->pageMenu = $pageMenu;
        $this->aside = $aside;
    }

    /**
     * Setup layout
     */
    public function setup()
    {
        $this->loginButton->setup();
        $this->pageMenu->setup();
        $this->aside->setup();
        $this->di->get('view')->add('layout/header', [], 'header');
    }
}
