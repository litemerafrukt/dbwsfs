<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\User\UserLevels;

class PostsController extends InjectionAwareClass
{
    /**
     * posts root page
     */
    public function index()
    {
        $posts = $this->di->posts->all();
        $this->showPostList($posts, "Hem");
    }

    /**
     * Show only posts
     */
    public function posts()
    {
        $posts = $this->di->posts->all('p');
        $this->showPostList($posts, "Inlägg");
    }

    /**
     * Show only questions
     */
    public function questions()
    {
        $posts = $this->di->posts->all('q');
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
        $posts = $this->di->tagsPosts->postsByTag($tag);
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
            $post->nrOfComments = $this->di->comments->countCommentsFor($post->id);
            $post->points += $this->di->comments->commentPointsFor($post->id);
            return $post;
        }, $posts);

        $posts = \array_reverse($posts);

        $this->di->get('pageRender')->quick("posts/posts", $title, \compact('posts', 'user', 'tag'));
    }
}
