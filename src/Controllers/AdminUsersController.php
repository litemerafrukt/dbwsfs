<?php

namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\User\UserLevels;

/**
 * Controller for admin stuff
 */
class AdminUsersController extends InjectionAwareClass
{
    /**
     * Show users admin page
     */
    public function users()
    {
        $userLevels = new UserLevels();
        $users = $this->di->usersHandler
            ->all()
            ->map(function ($user) use ($userLevels) {
                $user['userlevel'] = $userLevels->levelToString($user['userlevel']);
                return $user;
            })
            ->toArray();
        $this->di->get('pageRender')->quick('admin/users', "Administrera användare", \compact('users'));
    }

    /**
     * Show register page
     */
    public function register()
    {
        $this->di->get('pageRender')->quick('admin/user/register', "Registrera ny användare");
    }

    /**
     * Register and login new user
     */
    public function handleRegister()
    {
        $name = \trim($this->di->get('request')->getPost('username', ''));
        $email = \trim($this->di->get('request')->getPost('email', ''));

        if ($name === '' || $email === '') {
            $this->di->get('flash')->setFlash('Både användernamn och e-postadress måste anges.', 'flash-info');
            $this->di->get('response')->redirectPrevious();
        }

        $password1 = \trim($this->di->get('request')->getPost('password1', ''));
        $password2 = \trim($this->di->get('request')->getPost('password2', ''));

        if ($password1 === '' || $password2 === '') {
            $this->di->get('flash')->setFlash('Lösenord får inte vara tomt.', 'flash-info');
            $this->di->get('response')->redirectPrevious();
        }

        if ($password1 !== $password2) {
            $this->di->get('flash')->setFlash('Lösenorden stämmer inte med varandra.', 'flash-warning');
            $this->di->get('response')->redirectPrevious();
        }

        list($ok, $userOrMessage) = $this->di->userHandler->register($name, $password1, $email);

        if (! $ok) {
            $this->di->get('flash')->setFlash($userOrMessage, 'flash-danger');
            $this->di->get('response')->redirectPrevious();
        }
        $this->di->get('flash')->setFlash("Användare $name lades till", 'flash-success');
        $this->di->get('response')->redirect('admin/users');
    }

    /**
     * Show admin user edit profile
     *
     * @param int $id
     */
    public function edit($id)
    {
        $user = $this->di->usersHandler->fetchUser($id);
        if (! $user) {
            $this->di->get('flash')->setFlash("Hittar inte användare med id: $id", 'flash-danger');
            $this->di->get('response')->redirectPrevious();
        }
        $this->di->get('pageRender')->quick('admin/user/editprofile', "Uppdatera {$user['username']}", \compact('user'));
    }

    /**
     * Handle edit user profile
     *
     * @param int $id
     */
    public function handleEdit($id)
    {
        $user = $this->di->usersHandler->fetchUser($id);
        if (! $user) {
            $this->di->get('flash')->setFlash("Hittar inte användare med id: $id", 'flash-danger');
            $this->di->get('response')->redirectPrevious();
        }

        $name = \trim($this->di->get('request')->getPost('username', ''));
        $email = \trim($this->di->get('request')->getPost('email', ''));

        if ($name === '' || $email === '') {
            $this->di->get('flash')->setFlash('Både användernamn och e-postadress måste anges.', 'flash-info');
            $this->di->get('response')->redirectPrevious();
        }

        list($ok, $message) = $this->di->userHandler->update($user['id'], $name, $email);

        if (! $ok) {
            $this->di->get('flash')->setFlash($message, "flash-danger");
            $this->di->get('response')->redirectPrevious();
        }
        $this->di->get('flash')->setFlash($message, "flash-success");
        $this->di->get('response')->redirect("admin/users");
    }

    /**
     * Delete user with id
     *
     * @param int $id
     */
    public function delete($id)
    {
        list($ok, $message) = $this->di->usersHandler->deleteUser($id);

        if (! $ok) {
            $this->di->get('flash')->setFlash($message, "flash-danger");
            $this->di->get('response')->redirectPrevious();
        }
        $this->di->get('flash')->setFlash($message, "flash-success");
        $this->di->get('response')->redirectPrevious();
    }

    /**
     * Delete user with id
     *
     * @param int $id
     */
    public function activate($id)
    {
        list($ok, $message) = $this->di->usersHandler->activateUser($id);

        if (! $ok) {
            $this->di->get('flash')->setFlash($message, "flash-danger");
            $this->di->get('response')->redirectPrevious();
        }
        $this->di->get('flash')->setFlash($message, "flash-success");
        $this->di->get('response')->redirectPrevious();
    }

    /**
     * Make user with id admin
     *
     * @param int $id
     */
    public function makeAdmin($id)
    {
        list($ok, $message) = $this->di->usersHandler->makeAdmin($id);

        if (! $ok) {
            $this->di->get('flash')->setFlash($message, "flash-danger");
            $this->di->get('response')->redirectPrevious();
        }
        $this->di->get('flash')->setFlash($message, "flash-success");
        $this->di->get('response')->redirectPrevious();
    }
}
