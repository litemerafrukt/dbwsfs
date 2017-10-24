<?php
namespace litemerafrukt\Tags;

use \Anax\Database\ActiveRecordModel;

class TagModel extends ActiveRecordModel
{
    protected $tableName = "tags";

    public $id;
    public $tag;

    /**
     * Create and return a new tag
     */
    public function new($tagName)
    {
        $tag = new TagModel();
        $tag->tag = $tagName;
        $tag->setDb($this->db);
        return $tag;
    }
    /**
     * Get sorted top tags
     */
    public function toptags($limit = 5)
    {
        $this->db->connect();
        $sql = 'SELECT tag, count(PT.postId) AS tagCount FROM tags AS T INNER JOIN postTagLinks AS PT ON T.id = PT.tagId GROUP BY T.id ORDER BY tagCount desc LIMIT ?';
        return $this->db->executeFetchAll($sql, [$limit]);
    }
}
