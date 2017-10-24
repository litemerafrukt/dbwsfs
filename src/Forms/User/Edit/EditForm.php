<?php

namespace litemerafrukt\Forms\User\Edit;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class EditForm extends FormModel
{
    private $userHandler;
    private $user;

    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $userhandler, $user)
    {
        parent::__construct($di);

        $this->userHandler = $userhandler;
        $this->user = $user;

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Andra användaruppgifter"
            ],
            [
                "username" => [
                    "label"     => "Användarnamn",
                    "type"      => "text",
                    "required"  => true,
                    "class"     => "comments-input",
                    "value"     => $this->user->name,
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
                    "value"     => $this->user->email,
                    "validation" => [
                        "custom_test" => [
                            "message" => "Ange en e-postadress",
                            "test" => function ($value) {
                                return filter_var($value, FILTER_VALIDATE_EMAIL);
                            }
                        ]
                    ],
                ],

                "submit" => [
                    "class" => "button float-right",
                    "type" => "submit",
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
        $name = $this->form->value('username');
        $email = $this->form->value('email');

        list($ok, $message) = $this->userHandler->update($this->user->id, $name, $email);


        if (!$ok) {
            $this->di->get('flash')->setFlash($message, "flash-danger");
            return false;
        }

        $this->di->get('flash')->setFlash($message, "flash-success");

        $this->di->get('session')->set('user', $this->user->newFromThis(\compact('name', 'email')));

        return true;
    }

    /**
     * On success after submit
     */
    public function callbackSuccess()
    {
        $this->di->get('response')->redirect("user/profile");
    }
}
