<?php

namespace litemerafrukt\Posts;

use \Anax\Database\ActiveRecordModel;

class PostModel extends ActiveRecordModel
{
    protected $tableName = "posts";

    public $id;
    public $subject;
    public $author;
    public $authorId;
    public $authorEmail;
    public $rawText;
    public $points;
    public $type;
    public $created;
    public $updated;

    /**
     * Create and return a new post
     */
    public function new($subject, $authorId, $author, $authorEmail, $text, $type)
    {
        $post = new PostModel();
        $post->subject = \trim($subject);
        $post->authorId = $authorId;
        $post->author = \trim($author);
        $post->authorEmail = \trim($authorEmail);
        $post->rawText = \trim($text);
        $post->points = 0;
        $post->type = $type;
        $post->created = \date("Y-m-d H:i:s");

        $post->setDb($this->db);

        return $post;
    }

    /**
     * Get text formatted with $formatter
     *
     * @param callable $formatter callback that get raw comment as input
     *
     * @return output of formatter callback
     */
    public function getText($formatter)
    {
        return $formatter($this->rawText);
    }
}
