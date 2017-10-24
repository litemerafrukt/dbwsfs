<?php
namespace litemerafrukt\Forms\User\Login;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class LoginForm extends FormModel
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
                "legend" => "Login"
            ],
            [
                "username" => [
                    "label" => "Användarnamn",
                    "type" => "text",
                    "class" => "comments-input",
                    "required" => true,
                    // "validation" => ['not_empty'],
                    "validation" => [
                        "custom_test" => [
                            "message" => "Användarnamn måste anges",
                            "test" => function ($value) {
                                return !empty($value);
                            }
                        ]
                    ],
                    // "description" => "Användarnamn",
                    // "placeholder" => "<användarnamn>",
                ],

                "password" => [
                    "label" => "Lösenord",
                    "type" => "password",
                    "class" => "comments-input",
                    "required" => true,
                    // "validation" => ['not_empty'],
                    "validation" => [
                        "custom_test" => [
                            "message" => "Lösenord måste anges",
                            "test" => function ($value) {
                                return !empty($value);
                            }
                        ]
                    ],
                    // "description" => "Lösenord",
                    // "placeholder" => "<lösenord>",
                ],

                "submit" => [
                    "class" => "button float-right",
                    "type" => "submit",
                    "value" => "Logga in",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okej, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $username = $this->form->value('username');
        $password = $this->form->value('password');


        list($ok, $userOrMessage) = $this->userHandler->login($username, $password);

        if (!$ok) {
            $this->di->get('session')->delete('user');
            $this->di->get('flash')->setFlash($userOrMessage, "flash-info");
            return false;
        }

        $this->di->get('session')->set('user', $userOrMessage);
        $this->di->get('flash')->setFlash("Inloggad som $username", "flash-success");

        // $this->form->rememberValues();

        return true;
    }
}
