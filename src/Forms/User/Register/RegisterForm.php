<?php

namespace litemerafrukt\Forms\User\Register;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class RegisterForm extends FormModel
{
    private $userHandler;
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $userHandler)
    {
        parent::__construct($di);

        $this->userHandler = $userHandler;

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Registera ny användare"
            ],
            [
                "username" => [
                    "label"     => "Användarnamn",
                    "type"      => "text",
                    "required"  => true,
                    "class"     => "comments-input",
                    "validation" => [
                        "custom_test" => [
                            "message" => "Användarnamn måste anges",
                            "test" => function ($value) {
                                return !empty($value);
                            }
                        ]
                    ],
                ],
                "email" => [
                    "label"     => "E-postadress",
                    "type"      => "text",
                    "required"  => true,
                    "class"     => "comments-input",
                    "validation" => [
                        "custom_test" => [
                            "message" => "Ange en e-postadress",
                            "test" => function ($value) {
                                return filter_var($value, FILTER_VALIDATE_EMAIL);
                            }
                        ]
                    ],
                ],
                "password1" => [
                    "label" => "Lösenord",
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
                    "label" => "Repetera lösenord",
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
                    "class" => "button float-right",
                    "type" => "submit",
                    "value" => "Registera",
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
        $username = $this->form->value('username');
        $email = $this->form->value('email');
        $password1 = $this->form->value('password1');
        $password2 = $this->form->value('password2');

        if ($password1 !== $password2) {
            $this->di->get('flash')->setFlash('Lösenorden stämmer inte med varandra.', 'flash-danger');
            return false;
        }

        list($ok, $userOrMessage) = $this->userHandler->register($username, $password1, $email);

        if (!$ok) {
            $this->di->get('flash')->setFlash($userOrMessage, 'flash-danger');
            return false;
        }

        $this->di->get('session')->set('user', $userOrMessage);

        $this->form->rememberValues();

        return true;
    }
}
