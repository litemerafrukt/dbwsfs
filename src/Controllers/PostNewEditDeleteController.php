<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;
use litemerafrukt\Posts\Posts;
use litemerafrukt\User\UserLevels;
use litemerafrukt\Forms\Post\NewPost\NewPostForm;
use litemerafrukt\Forms\Post\EditPost\EditPostForm;

use litemerafrukt\Comments\Comments;

class PostNewEditDeleteController extends InjectionAwareClass
{
    private $posts;
    private $comments;

    public function __construct(Posts $postHandler, Comments $comments)
    {
        $this->posts = $postHandler;
        $this->comments = $comments;
    }

    /**
     * Add a post
     *
     * @param $type - 'q'|'p'
     */
    public function new($type)
    {
        $this->guard();

        $form = new NewPostForm($this->di, $this->posts, $type);

        $form->check();

        $formHTML = $form->getHTML(['use_fieldset' => false]);

        $type = $type == "q" ? "q" : "p";
        $title = $type == "q" ? "Ny fråga" : "Nytt inlägg";

        $this->di->get('pageRender')->quick('posts/newedit', $title, ['form' => $formHTML, 'title' => $title]);
    }

    public function edit($id)
    {
        $this->guard();
        $post = $this->posts->fetch($id);

        if ($post === null) {
            $this->di->get('flash')->setFlash("Inlägget med id: $id hittades inte.", "flash-danger");
            $this->di->get('response')->redirectPrevious();
        }

        $form = new EditPostForm($this->di, $this->posts, $post);

        $form->check();

        $formHTML = $form->getHTML(['use_fieldset' => false]);

        $this->di->get('pageRender')->quick('posts/newedit', "{$post->subject}", ['form' => $formHTML, 'title' => $post->subject]);
    }

    /**
     * Delete a post
     */
    public function delete($id)
    {
        $this->guard($id);

        $this->posts->delete($id);
        $this->comments->deleteComments($id);

        $this->di->get('flash')->setFlash("Inlägget raderat.", "flash-info");

        $this->di->get('response')->redirect("");
    }

    /**
     * Guard comment handling
     *
     * @param int $postId
     */
    private function guard($postId = null)
    {
        $user = $this->di->get('user');

        if ($user->isLevel(UserLevels::ADMIN)) {
            return;
        }

        if ($user->isLevel(UserLevels::USER) && $postId == null) {
            return;
        }

        $post = $this->posts->fetch($postId);

        if ($user->isLevel(UserLevels::USER) && ($post->authorId == $user->id())) {
            return $postId;
        }

        $this->di->get('flash')->setFlash('Logga in först', 'flash-danger');
        $this->di->get('response')->redirect('');
    }
}
