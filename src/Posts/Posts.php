<?php

namespace litemerafrukt\Posts;

use litemerafrukt\Tags\TagsPosts;
use litemerafrukt\Tags\TagModel;

class Posts
{
    private $postModel;
    private $tagModel;
    private $tagsPosts;

    /**
     * @param CommentStorage $storage
     * @param callback $textFormatter
     */
    public function __construct(PostModel $postModel, TagModel $tagModel, TagsPosts $tagsPosts)
    {
        $this->postModel = $postModel;
        $this->tagModel = $tagModel;
        $this->tagsPosts = $tagsPosts;
    }

    /**
     * All posts, optionally all by type
     *
     * @param string
     *
     * @return array
     */
    public function all($type = null)
    {
        $posts = $type === null
            ? $this->postModel->findAll()
            : $this->postModel->findAllWhere('type=?', $type);

        return $posts;
    }

    /**
     * Add a post
     *
     * @param string
     * @param int
     * @param string
     * @param string
     * @param string
     * @param array
     *
     * @return array
     */
    public function add($subject, $authorId, $author, $authorEmail, $text, $type, $tags)
    {
        $post = $this->postModel->new($subject, $authorId, $author, $authorEmail, $text, $type);
        $post->save();

        $this->tagsHandling($post->id, $tags);
    }

    /**
     * Update/replace a post
     *
     * @param integer
     * @param string
     * @param string
     * @param string
     * @param string
     *
     * @return array
     */
    public function upsert($id, $subject, $text, $tags)
    {
        unset($this->postModel->tags);
        $post = $this->postModel->find("id", $id);

        $post->subject = $subject;
        $post->rawText = $text;
        $post->updated = \date("Y-m-d H:i:s");

        $post->save();

        $this->tagsPosts->deleteWhere('postId=?', $id);
        $this->tagsHandling($post->id, $tags);
    }

    /**
     * Delete a post by id
     *
     * @param integer
     */
    public function delete($id)
    {
        $this->postModel->delete($id);
        $this->tagsPosts->deleteWhere('postId=?', $id);
    }

    /**
     * Fetch post by id
     *
     * @return PostModel
     */
    public function fetch($id)
    {
        $post = $this->postModel->find('id', $id);
        $post->tags = $this->tagsPosts->tagsForPost($id);
        return $post;
    }

    /**
     * Vote on a comment
     *
     * @param integer
     * @param integer
     */
    public function vote($id, $points)
    {
        $post = $this->postModel->find("id", $id);
        $post->points = $post->points + $points;
        $post->save();
    }

    /**
     * Handle tag insertion and post <-> tag coupling
     */
    private function tagsHandling($postId, $tags)
    {
        $tags = \array_filter($tags, function ($tag) {
            return !empty(trim($tag));
        });

        \array_walk($tags, function ($tag) use ($postId) {
            $arTag = $this->tagModel->find('tag', $tag)
                ?: $this->tagModel->new($tag);
            $arTag->save();

            $tagPostCoupling = $this->tagsPosts->new($postId, $arTag->id);
            $tagPostCoupling->save();
        });
    }
}
