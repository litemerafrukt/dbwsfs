<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\Gravatar\Gravatar;
use litemerafrukt\User\UserLevels;

class PostController extends InjectionAwareClass
{
    private $formatter;

    public function __construct($formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Vote on a post
     *
     * @param int $postId
     */
    public function vote($id)
    {
        $user = $this->di->get('user');

        if (!$user->isLevel(UserLevels::USER)) {
            $this->response->redirectPrevious();
        }

        $this->di->get('userCred')->addCred(1);

        if ($this->di->request->getPost('vote-up-submitted', false)) {
            $this->di->posts->vote($id, 1);
        } else if ($this->di->request->getPost('vote-down-submitted', false)) {
            $this->di->posts->vote($id, -1);
        }

        $this->di->get('response')->redirectPrevious();
    }

    /**
     * Show a post
     *
     * @param int $postId
     */
    public function show($id)
    {
        $post = $this->di->posts->fetch($id);
        $post->gravatar = new Gravatar($post->authorEmail);
        $post->points += $this->di->comments->commentPointsFor($post->id);

        $user = $this->di->get('user');
        $user->isUser = $user->isLevel(UserLevels::USER);
        $user->isAdmin = $user->isLevel(UserLevels::ADMIN);

        $sortBy = $this->di->request->getGet('sort', 'id');

        $urlCreator = [$this->di->get('url'), "create"];

        $commentsHTML = $this->di->comments->getHtml($id, $post->authorId, $user, $sortBy, $urlCreator);

        $viewData = \array_merge(
            \compact('post', 'user', 'commentsHTML', 'sortBy'),
            ["formatter" => $this->formatter]
        );

        $this->di->get('pageRender')->quick("posts/post", $post->subject, $viewData);
    }
}
