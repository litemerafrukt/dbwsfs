<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\Posts\Posts;
use litemerafrukt\Tags\TagsPosts;
use litemerafrukt\Gravatar\Gravatar;
use litemerafrukt\User\UserLevels;

use litemerafrukt\Comments\Comments;

class PostsController extends InjectionAwareClass
{
    private $posts;
    private $comments;
    private $tagsPosts;

    public function __construct(Posts $postsHandler, Comments $comments, TagsPosts $tagsPosts)
    {
        $this->posts = $postsHandler;
        $this->comments = $comments;
        $this->tagsPosts = $tagsPosts;
    }

    /**
     * posts root page
     */
    public function index()
    {
        $posts = $this->posts->all();
        $this->showPostList($posts, "Hem");
    }

    /**
     * Show only posts
     */
    public function posts()
    {
        $posts = $this->posts->all('p');
        $this->showPostList($posts, "Inlägg");
    }

    /**
     * Show only questions
     */
    public function questions()
    {
        $posts = $this->posts->all('q');
        $this->showPostList($posts, "Frågor");
    }

    /**
     * Posts for a tag
     *
     * @param string
     *
     * @return array
     */
    public function postsByTag($tag)
    {
        $posts = $this->tagsPosts->postsByTag($tag);
        $this->showPostList($posts, $tag, $tag);
    }

    /**
     * Show the posts
     *
     * @param $posts
     */
    private function showPostList($posts, $title, $tag = null)
    {
        $user = $this->di->get('user');
        $user->isUser = $user->isLevel(UserLevels::USER);

        $posts = \array_map(function ($post) {
            $post->nrOfComments = $this->comments->countCommentsFor($post->id);
            $post->points += $this->comments->commentPointsFor($post->id);
            return $post;
        }, $posts);

        $posts = \array_reverse($posts);

        $this->di->get('pageRender')->quick("posts/posts", $title, \compact('posts', 'user', 'tag'));
    }
}
