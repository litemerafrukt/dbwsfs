<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\User\UserLevels;

class CommentHandleController extends InjectionAwareClass
{
    /**
     * New or edit comment post request
     *
     * @param integer
     */
    public function newEditComment($postId)
    {
        $post = $this->di->posts->fetch($postId);
        $points = $post->points + $this->di->comments->commentPointsFor($post->id);

        $user = $this->user();

        if ($this->di->request->getPost('new-comment-submitted', false) && $user->isUser) {
            $authorId = $user->id;
            $authorName = $user->name;
            $parentId = $this->di->request->getPost('parent-id', 0);
            $text = \trim($this->di->request->getPost('comment-new-text'));
            $this->di->comments->new($postId, $parentId, $authorId, $authorName, $text);

            $this->di->get('userCred')->addCred($points + 5);
        } else if ($this->di->request->getPost('edit-comment-submitted', false) && $user->isUser) {
            $id = $this->di->request->getPost('comment-id', null);
            $text = \trim($this->di->request->getPost('comment-edit-text', ''));
            $this->di->comments->update($id, $text, function ($comment) use ($user) {
                return $comment->authorId == $user->id || $user->isAdmin;
            });
        }
    }

    /**
     * Mark or unmark a comment
     *
     * @param integer
     */
    public function toggleMark($commentId)
    {
        $comment = $this->di->commentModel->find("id", $commentId);
        $post = $this->di->postModel->find("id", $comment->postId);
        if ($this->user()->id == $post->authorId) {
            $this->di->comments->toggleMarked($commentId);
        }
        $this->di->get("response")->redirect($this->di->get('previousRoute'));
    }

    /**
     * Vote up comment
     *
     * @param integer
     */
    public function voteUp($commentId)
    {
        $this->vote($commentId, 1);
    }

    /**
     * Vote up comment
     *
     * @param integer
     */
    public function voteDown($commentId)
    {
        $this->vote($commentId, -1);
    }

    /**
     * Vote for comment
     *
     * @param integer
     * @param integer
     */
    public function vote($commentId, $points)
    {
        if ($this->user()->isUser) {
            $this->di->comments->vote($commentId, $points);
            $this->di->get('userCred')->addCred(1);
        }
        $this->di->get("response")->redirect($this->di->get('previousRoute'));
    }

    private function user()
    {
        $user = $this->di->get('user');
        $user->isUser = $user->isLevel(UserLevels::USER);
        $user->isAdmin = $user->isLevel(UserLevels::ADMIN);
        return $user;
    }
}
