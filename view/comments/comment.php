<li class="comment-li">
    <a name="comment<?= $comment->id ?>"></a>
    <div class="comment-main <?= $comment->marked ? "comment-marked" : "" ?>">
        <p>
            <?= $formatter(htmlentities($comment->text)) ?>
        </p>
        <p class="comment-author-created">
            <strong>
                <a href="<?= $urlCreator('user/profile/'.$comment->authorName) ?>">
                    <?= htmlentities($comment->authorName) ?>
                </a>
            </strong>
            <span> ; <?= $comment->points ?> poäng </span>
            @ <?= $comment->created ?> <?= $comment->updated ? "& $comment->updated" : '' ?>
        </p>
    </div>
    <?php if ($user->isUser) : ?>
        <form method="post" action="#comment<?= $comment->id ?>">
            <a class="comment-button" href="<?= $urlCreator('post/voteup/'.$comment->id) ?>">+1</a>
            <a class="comment-button" href="<?= $urlCreator('post/votedown/'.$comment->id) ?>">-1</a>

            <?php if ($user->id == $postAuthorId) : ?>
                <a class="comment-button" href="<?= $urlCreator('post/mark/'.$comment->id) ?>">markera</a>
            <?php endif ?>

            <input type="hidden" name="comment-id" value="<?= $comment->id ?>">

            <?php if ($user->isAdmin || ($user->id == $comment->authorId)) : ?>
                <button
                    class="comment-edit-reply-toggler comment-button"
                    data-target="edit-comment<?= $comment->id ?>"
                    data-close="reply-comment<?= $comment->id ?>"
                >
                    ändra
                </button>
            <?php endif ?>

            <button
                class="comment-edit-reply-toggler comment-button"
                data-target="reply-comment<?= $comment->id ?>"
                data-close="edit-comment<?= $comment->id ?>"
            >
                svara
            </button>

            <div class="comment-reply-form noshow" id="reply-comment<?= $comment->id ?>">
                <textarea name="comment-new-text" cols="25" rows="3"></textarea>
                <br>
                <input type="hidden" name="parent-id" value="<?= $comment->id ?>">
                <input class="button" type="submit" name="new-comment-submitted" value="Svara">
                <button
                    class="comment-cancel button"
                    data-close="reply-comment<?= $comment->id ?>"
                >
                    Ångra
                </button>
            </div>

            <?php if ($user->isAdmin || ($user->id == $comment->authorId)) : ?>
                <div class="comment-edit-form noshow" id="edit-comment<?= $comment->id ?>">
                    <textarea name="comment-edit-text" cols="25" rows="3"><?= htmlentities($comment->text) ?></textarea>
                    <br>
                    <input class="button" type="submit" name="edit-comment-submitted" value="Ändra">
                    <button
                        class="comment-cancel button"
                        data-close="edit-comment<?= $comment->id ?>"
                    >
                        Ångra
                    </button>
                </div>
            <?php endif ?>
        </form>
    <?php endif ?>

    <?php if (isset($commentGroups[$comment->id])) : ?>
        <?php
            $comments = $commentGroups[$comment->id];
            include __DIR__.'/commentlist.php';
        ?>
    <?php endif ?>
</li>
