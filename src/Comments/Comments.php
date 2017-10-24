<?php

namespace litemerafrukt\Comments;

class Comments
{
    private $commentModel;
    private $formatter;
    private $rootView;

    /**
     * Construct
     *
     * @param $commentModel
     * @param $formatter - formatter for comment text
     * @param $rootView - root view file for comments html rendering. See source for example.
     */
    public function __construct($commentModel, $formatter, $rootView = __DIR__.'/../../view/comments/comments.php')
    {
        $this->commentModel = $commentModel;
        $this->formatter = $formatter;
        $this->rootView = $rootView;
    }

    /**
     * Create a comment
     *
     * @param $postId
     * @param $parentId - parent comment
     * @param $authorId - author/user id
     * @param $authorName - author/user name
     * @param $text - comment text
     *
     * @return void
     */
    public function new($postId, $parentId, $authorId, $authorName, $text)
    {
        if (\trim($text) === "") {
            return;
        }

        $comment = $this->commentModel->new($postId, $parentId, $authorId, $authorName, $text);
        $comment->save();

        // $this->commentHandler->new($postId, $parentId, $authorId, $authorName, $text);
    }

    /**
     * Update a comment
     *
     * @param $id - comment id
     * @param $text - comment text
     * @param $guard - function, comment only updates if guard returns true
     *
     * @return bool
     */
    public function update($id, $text, $guard)
    {
        $comment = $this->commentModel->find("id", $id);

        if (! $guard($comment)) {
            return false;
        }

        $comment->text = $text;
        $comment->updated = \date("Y-m-d H:i:s");

        $comment->save();

        return true;
    }

    /**
     * Delete all comments associated with a post.
     *
     * @param $postId
     *
     * @return void
     */
    public function deleteComments($postId)
    {
        $this->commentModel->deleteWhere('postId=?', $postId);
    }

    /**
     * Add points to comment
     *
     * @param $id
     * @param $points
     */
    public function vote($id, $points)
    {
        $comment = $this->commentModel->find("id", $id);
        $comment->points = $comment->points + $points;
        $comment->save();
    }

    /**
     * Toggle marked
     *
     * @param $id
     */
    public function toggleMarked($id)
    {
        $comment = $this->commentModel->find("id", $id);
        $comment->marked = $comment->marked == 0 ? 1 : 0;
        $comment->save();
    }

    /**
     * Get comment html for a post. All comments and save/edit forms.
     *
     * @param $postId
     * @param $user - app user object
     * @param $sortBy - column to sort by
     *
     * @return string
     */
    public function getHtml($postId, $postAuthorId, $user, $sortBy, $urlCreator)
    {
        $commentGroups = $this->commentModel->groupedCommentsForPost($postId, $sortBy);

        $formatter = $this->formatter;

        return $this->render(
            $this->rootView,
            \compact(
                'commentGroups',
                'formatter',
                'postAuthorId',
                'user',
                'urlCreator'
            )
        );
    }

    /**
     * Count nr of comments for a post
     *
     * @param $postId
     *
     * @return int
     */
    public function countCommentsFor($postId)
    {
        return $this->commentModel->countCommentsFor($postId);
    }

    /**
     * Count all points for comments for post
     *
     * @param postId
     *
     * @return int
     */
    public function commentPointsFor($postId)
    {
        return $this->commentModel->commentPointsFor($postId);
    }

    /**
     * Render view file with data.
     *
     * @param $file
     * @param $data
     * @return string
     * @throws \Exception
     */
    private function render($file, $data)
    {
        if (!file_exists($file)) {
            throw new \Exception("View template not found: $file.");
        }

        ob_start();

        extract($data);

        include $file;

        $output = ob_get_clean();

        return $output;
    }
}
