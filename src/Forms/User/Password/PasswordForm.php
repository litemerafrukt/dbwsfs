<?php

namespace litemerafrukt\Forms\User\Password;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class PasswordForm extends FormModel
{
    private $userHandler;
    private $user;

    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $userHandler, $user)
    {
        parent::__construct($di);

        $this->userHandler = $userHandler;
        $this->user = $user;

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "User Login"
            ],
            [
                "password1" => [
                    "label" => "Nytt lösenord",
                    "type" => "password",
                    "class" => "comments-input",
                    "required" => true,
                    "validation" => [
                        "custom_test" => [
                            "message" => "Lösenord måste anges",
                            "test" => function ($value) {
                                return !empty($value);
                            }
                        ]
                    ],
                ],
                "password2" => [
                    "label" => "Repetera nytt lösenord",
                    "type" => "password",
                    "class" => "comments-input",
                    "required" => true,
                    "validation" => [
                        "custom_test" => [
                            "message" => "Lösenordet måste anges två gånger",
                            "test" => function ($value) {
                                return !empty($value);
                            }
                        ]
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "class" => "button float-right",
                    "value" => "Ändra",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $password1 = $this->form->value('password1');
        $password2 = $this->form->value('password2');

        if ($password1 !== $password2) {
            $this->di->get('flash')->setFlash('Lösenorden stämmer inte med varandra.', 'flash-danger');
            return false;
        }

        list($ok, $message) = $this->userHandler->changePassword($this->user->id(), $password1);

        if (! $ok) {
            $this->di->get('flash')->setFlash($message, "flash-danger");
            return false;
        }
        $this->di->get('flash')->setFlash($message, "flash-success");

        return true;
    }

    /**
     * On success after submit
     */
    public function callbackSuccess()
    {
        $this->di->get('response')->redirect("user/account/profile");
    }
}
