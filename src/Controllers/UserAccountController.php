<?php

namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\Gravatar\Gravatar;
use litemerafrukt\User\UserLevels;
use litemerafrukt\User\User;
use litemerafrukt\Forms\User\Edit\EditForm;
use litemerafrukt\Forms\User\Password\PasswordForm;

/**
 * Controller for user account stuff, change profile, change password etc.
 */
class UserAccountController extends InjectionAwareClass
{
    private $userHandler;

    public function __construct($userHandler)
    {
        $this->userHandler = $userHandler;
    }

    /**
     * Show user profile and logout option
     */
    public function profile($username = null)
    {
        $publicProfile = true;
        if ($username === null || $username === $this->di->get('user')->name) {
            $user = $this->di->get('user');
            $publicProfile = false;
        } else {
            $userFromDb = $this->di->get('usersHandler')->fetchUserByName($username);
            $user = new User(
                $userFromDb['id'],
                $userFromDb['username'],
                $userFromDb['email'],
                $userFromDb['userlevel'],
                $userFromDb['cred']
            );
        }

        $user->gravatar = new Gravatar($user->email());
        $user->isAdmin = $user->isLevel(UserLevels::ADMIN);

        $posts = $this->di->get('postModel')->findAllWhere('authorId=?', $user->id);
        $posts = \array_reverse($posts);

        $comments = $this->di->get('commentModel')->findAllWhere('authorId=?', $user->id);
        $comments = \array_reverse($comments);

        $this->di->get('pageRender')->quick(
            'user/profile',
            "Användare {$user->name()}",
            \compact('user', 'posts', 'comments', 'publicProfile')
        );
    }

    /**
     * Show user edit profile
     */
    public function editProfile()
    {
        $user = $this->di->get('user');

        $form = new EditForm($this->di, $this->userHandler, $user);

        $form->check();

        $formHTML = $form->getHTML(['use_fieldset' => false]);

        $this->di->get('pageRender')->quick('user/editprofile', "Uppdatera {$user->name()}", ['form' => $formHTML]);
    }

    /**
     * Show change password
     */
    public function changePassword()
    {
        $user = $this->di->get('user');

        $form = new PasswordForm($this->di, $this->userHandler, $user);

        $form->check();

        $formHTML = $form->getHTML(['use_fieldset' => false]);

        $this->di->get('pageRender')->quick('user/changepassword', "Ändra lösenord", ['form' => $formHTML]);
    }
}
