<?php

namespace litemerafrukt\Comments;

use Illuminate\Support\Collection;
use \Anax\Database\ActiveRecordModel;

class CommentModel extends ActiveRecordModel
{
    protected $tableName = "comments";

    public $id;
    public $postId;
    public $parentId;
    public $authorId;
    public $authorName;
    public $text;
    public $points;
    public $created;
    public $updated;

    /**
     * Create a new comment
     */
    public function new($postId, $parentId, $authorId, $authorName, $text)
    {
        $comment = new CommentModel();
        $comment->postId = $postId;
        $comment->parentId = $parentId;
        $comment->authorId = $authorId;
        $comment->authorName = $authorName;
        $comment->text = \trim($text);
        $comment->points = 0;
        $comment->created = \date("Y-m-d H:i:s");

        $comment->setDb($this->db);

        return $comment;
    }

    /**
     * Get comments for a post.
     *
     * @param $id - post id
     * @param $sortBy
     *
     * @return array - comments grouped by parent comment
     */
    public function groupedCommentsForPost($id, $sortBy = "id")
    {
        $comments = $this->findAllWhere('postId=?', $id);

        $groupedComments = collect($comments)
            ->sortByDesc($sortBy)
            ->groupBy('parentId');

        return $groupedComments->toArray();
    }

    /**
     * Get nr of comments for a post
     *
     * @param $id - postId
     *
     * @return int
     */
    public function countCommentsFor($id)
    {
        $comments = $this->findAllWhere('postId=?', $id);
        return \count($comments);
    }

    /**
     * Get total comment points for a post
     *
     * @param $id - postId
     *
     * @return int
     */
    public function commentPointsFor($id)
    {
        $comments = $this->findAllWhere('postId=?', $id);
        return \array_reduce($comments, function ($total, $comment) {
            return $total + $comment->points;
        }, 0);
    }
}
