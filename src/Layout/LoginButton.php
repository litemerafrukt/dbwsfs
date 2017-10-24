<?php

namespace litemerafrukt\Layout;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\User\UserLevels;
use litemerafrukt\Gravatar\Gravatar;

class LoginButton extends InjectionAwareClass
{
    /**
     * Setup login button
     */
    public function setup()
    {
        $this->di->get('view')->add('layout/loginbutton', ['icon' => $this->icon()], 'loginButton');
    }

    /**
     * Get login button icon
     *
     * @return string - html
     */
    public function icon()
    {
        $user = $this->di->get('user');
        if ($user->isLevel(UserLevels::USER)) {
            $imageUrl = (new Gravatar($user->email(), 35))->url();
            return "<img class=\"login-button\" src=\"$imageUrl\">";
        }
        return "<i class=\"login-button fa fa-sign-in\"></i>";
    }
}
