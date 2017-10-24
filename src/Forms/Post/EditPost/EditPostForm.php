<?php

namespace litemerafrukt\Forms\Post\EditPost;

use litemerafrukt\User\UserLevels;
use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class EditPostForm extends FormModel
{
    private $posts;
    private $post;

    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param $type - 'p'|'q'
     */
    public function __construct(DIInterface $di, $posts, $post)
    {
        parent::__construct($di);

        $this->posts = $posts;
        $this->post = $post;

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Nytt inlägg"
            ],
            [
                "subject" => [
                    "label"     => "Ämne",
                    "type"      => "text",
                    "required"  => true,
                    "class"     => "comments-input",
                    "value"     => $post->subject,
                    "validation" => [
                        "custom_test" => [
                            "message" => "Du behöver fylla i ett ämne.",
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
                    "value"     => \trim(\implode(" ", \array_map(function ($tag) {
                        return $tag->tag;
                    }, $post->tags))),
                ],
                "text" => [
                    "label"     => "Text",
                    "type"      => "textarea",
                    "class"     => "comments-text",
                    "value"     => $post->rawText,
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
        $tags = \preg_split('/[^\w]+/u', $this->form->value("tags"));

        $user = $this->di->get('user');

        if ($this->post->authorId != $user->id && !$user->isLevel(UserLevels::ADMIN)) {
            $this->di->get('flash')->setFlash("Nu är det nått skumt på gång...", "flash-warning");
            return false;
        }

        $this->posts->upsert($this->post->id, $subject, $text, $tags);
        $this->di->get('flash')->setFlash("\"{$subject}\", har ändrats.", "flash-success");

        return true;
    }
}
