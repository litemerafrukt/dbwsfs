<?php

namespace litemerafrukt\Tags;

use \Anax\Database\ActiveRecordModel;

/**
 * Couplings tags <-> posts
 */
class TagsPosts extends ActiveRecordModel
{
    protected $tableName = "postTagLinks";

    public $id;
    public $postId;
    public $tagId;


    /**
     * Create and return a new post <-> tag coupling
     */
    public function new($postId, $tagId)
    {
        $coupling = new TagsPosts();
        $coupling->postId = $postId;
        $coupling->tagId = $tagId;
        $coupling->setDb($this->db);
        return $coupling;
    }

    /**
     * All posts by tag
     */
    public function postsByTag($tag)
    {
        $this->db->connect();
        $sql = "SELECT P.* FROM posts AS P
            INNER JOIN postTagLinks AS PT ON P.id = PT.postId
            INNER JOIN tags as T ON T.id = PT.tagId
            WHERE tag = ?";
        return $this->db->executeFetchAll($sql, [$tag]);
    }

    /**
     * Tags for post
     */
    public function tagsForPost($postId)
    {
        $sql = "SELECT tag FROM tags AS T
            INNER JOIN postTagLinks AS PT ON T.id = PT.tagId
            INNER JOIN posts as P ON P.id = PT.postId
            WHERE P.id = ?";
        return $this->db->executeFetchAll($sql, [$postId]);
    }
}
