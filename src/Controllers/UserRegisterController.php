<?php

namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\User\UserLevels;
use litemerafrukt\Forms\User\Register\RegisterForm;
use litemerafrukt\Gravatar\Gravatar;

/**
 * Controller for user stuff, login, logout, register etc.
 */
class UserRegisterController extends InjectionAwareClass
{
    /**
     * Show register page
     */
    public function register()
    {
        if ($this->di->get('session')->get('user')) {
            $this->di->get('response')->redirect("user/profile");
        }

        $form = new RegisterForm($this->di, $this->di->userHandler);

        $form->check();

        $formHTML = $form->getHTML(['use_fieldset' => false]);

        $this->di->get('pageRender')->quick('user/register', "Registrera ny användare", ['form' => $formHTML]);
    }
}
