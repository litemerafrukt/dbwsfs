<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\User\UserLevels;
use litemerafrukt\Forms\User\Login\LoginForm;

/**
 * Controller for user stuff, login, logout and guard.
 */
class UserController extends InjectionAwareClass
{
    private $userHandler;

    public function __construct($userHandler)
    {
        $this->userHandler = $userHandler;
    }

    /**
     * Show login
     */
    public function login()
    {
        $user = $this->di->get('session')->get('user');
        if ($user) {
            $this->di->get('response')->redirect("user/profile");
        }

        $form = new LoginForm($this->di, $this->userHandler);

        $form->check();

        $formHTML = $form->getHTML(['use_fieldset' => false]);

        $this->di->get('pageRender')->quick('user/login', 'Logga in', ['form' => $formHTML]);
    }

    /**
     * Logout user by deleting user in session.
     */
    public function logout()
    {
        $this->di->get('session')->delete('user');
        $this->di->get('response')->redirect('user/login');
    }

    /**
     * Guard
     *
     * Only users is allowed, otherwise redirect.
     */
    public function guard()
    {
        if ($this->di->get('user')->isLevel(UserLevels::USER)) {
            return;
        }

        $this->di->get('flash')->setFlash("Endast tillgänglig för inloggade användare", "flash-danger");
        $this->di->get('response')->redirect("");
    }
}
