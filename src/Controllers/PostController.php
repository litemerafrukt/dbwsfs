<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\Posts\Posts;
use litemerafrukt\Gravatar\Gravatar;
use litemerafrukt\User\UserLevels;

use litemerafrukt\Comments\Comments;

class PostController extends InjectionAwareClass
{
    private $posts;
    private $formatter;
    private $comments;

    public function __construct(Posts $postsHandler, Comments $comments, $formatter)
    {
        $this->posts = $postsHandler;
        $this->formatter = $formatter;
        $this->comments = $comments;
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
            $this->posts->vote($id, 1);
        } else if ($this->di->request->getPost('vote-down-submitted', false)) {
            $this->posts->vote($id, -1);
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
        $post = $this->posts->fetch($id);
        $post->gravatar = new Gravatar($post->authorEmail);
        $post->points += $this->comments->commentPointsFor($post->id);

        $user = $this->di->get('user');
        $user->isUser = $user->isLevel(UserLevels::USER);
        $user->isAdmin = $user->isLevel(UserLevels::ADMIN);

        if ($this->di->request->getPost('new-comment-submitted', false) && $user->isUser) {
            $authorId = $user->id;
            $authorName = $user->name;
            $parentId = $this->di->request->getPost('parent-id', 0);
            $text = \trim($this->di->request->getPost('comment-new-text'));
            $this->comments->new($id, $parentId, $authorId, $authorName, $text);

            $this->di->get('userCred')->addCred($post->points + 5);

            $this->di->get("response")->redirectSelf();
        } else if ($this->di->request->getPost('edit-comment-submitted', false) && $user->isUser) {
            $id = $this->di->request->getPost('comment-id', null);
            $text = \trim($this->di->request->getPost('comment-edit-text', ''));
            $this->comments->update($id, $text, function ($comment) use ($user) {
                return $comment->authorId == $user->id || $user->isAdmin;
            });
            $this->di->get("response")->redirectSelf();
        } else if ($this->di->request->getPost('vote-up-comment-submitted', false) && $user->isUser) {
            $id = $this->di->request->getPost('comment-id', null);
            $this->comments->vote($id, 1);
            $this->di->get('userCred')->addCred(1);
            $this->di->get("response")->redirectSelf();
        } else if ($this->di->request->getPost('vote-down-comment-submitted', false) && $user->isUser) {
            $id = $this->di->request->getPost('comment-id', null);
            $this->comments->vote($id, -1);
            $this->di->get('userCred')->addCred(1);
            $this->di->get("response")->redirectSelf();
        } else if ($this->di->request->getPost('mark-comment-submitted', false) && $user->id == $post->authorId) {
            $id = $this->di->request->getPost('comment-id', null);
            $this->comments->toggleMarked($id);
            $this->di->get("response")->redirectSelf();
        };

        $sortBy = $this->di->request->getGet('sort', 'id');

        $urlCreator = [$this->di->get('url'), "create"];

        $commentsHTML = $this->comments->getHtml($id, $post->authorId, $user, $sortBy, $urlCreator);

        $viewData = \array_merge(
            \compact('post', 'user', 'commentsHTML', 'sortBy'),
            ["formatter" => $this->formatter]
        );

        $this->di->get('pageRender')->quick("posts/post", $post->subject, $viewData);
    }
}
