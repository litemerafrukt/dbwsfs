<?php

namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\User\UserLevels;

/**
 * Controller for admin stuff
 */
class AdminController extends InjectionAwareClass
{
    /**
     * Show admin main page
     */
    public function index()
    {
        $this->di->get('pageRender')->quick('admin/index', "Administrera");
    }

    /**
     * Guard
     *
     * Only admin is allowed, otherwise redirect.
     */
    public function guard()
    {
        if ($this->di->get('user')->isLevel(UserLevels::ADMIN)) {
            return;
        }

        $this->di->get('flash')->setFlash("Endast tillgänglig för sajtens administratörer.", "flash-danger");
        $this->di->get('response')->redirect("");
    }
}
