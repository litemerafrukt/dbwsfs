<?php

namespace litemerafrukt\Forms\Post\NewPost;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class NewPostForm extends FormModel
{
    private $posts;

    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param $type - 'p'|'q'
     */
    public function __construct(DIInterface $di, $posts, $type)
    {
        parent::__construct($di);

        $this->posts = $posts;

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Nytt inlägg"
            ],
            [
                "subject" => [
                    "label"     => "Titel",
                    "type"      => "text",
                    "required"  => true,
                    "class"     => "comments-input",
                    "validation" => [
                        "custom_test" => [
                            "message" => "Du behöver fylla i en titel.",
                            "test" => function ($value) {
                                return !empty($value);
                            }
                        ]
                    ],
                ],
                "tags" => [
                    "label"     => "Taggar",
                    "type"      => "text",
                    "class"     => "comments-input",
                ],
                "text" => [
                    "label"     => "Text",
                    "type"      => "textarea",
                    "class"     => "comments-text",
                ],
                "type" => [
                    "label" => "",
                    "type" => "hidden",
                    "value" => $type,
                ],
                "submit" => [
                    "class" => "button",
                    "type" => "submit",
                    "value" => "Posta",
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
        $subject = $this->form->value("subject");
        $text = $this->form->value("text");
        $type = $this->form->value("type");
        $tags = \preg_split('/[^\w]+/u', $this->form->value("tags"));

        $user = $this->di->get('user');

        $this->posts->add($subject, $user->id, $user->name, $user->email, $text, $type, $tags);

        $this->di->get('userCred')->addCred(5);

        $this->di->get('flash')->setFlash("\"{$subject}\", har postats.", "flash-success");

        return true;
    }
}
