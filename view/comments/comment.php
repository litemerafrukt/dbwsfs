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
            @ <?= $comment->created ?> & <?= $comment->updated ?>
        </p>
    </div>
    <?php if ($user->isUser) : ?>
        <form method="post" action="#comment<?= $comment->id ?>">
            <input type="hidden" name="comment-id" value="<?= $comment->id ?>">
            <input class="comment-button" type="submit" name="vote-up-comment-submitted" value="+1">
            <input class="comment-button" type="submit" name="vote-down-comment-submitted" value="-1">
            <?php if ($user->id == $postAuthorId) : ?>
                <input class="comment-button" type="submit" name="mark-comment-submitted" value="markera">
            <?php endif ?>
            <?php if ($user->isAdmin || ($user->id == $comment->authorId)) : ?>
                <button class="comment-next-sibling-toggler comment-button">
                    ändra
                </button>
                <div class="comment-edit-form noshow" method="post">
                    <textarea name="comment-edit-text" cols="25" rows="3"><?= htmlentities($comment->text) ?></textarea>
                    <br>
                    <input type="submit" name="edit-comment-submitted" value="Ändra">
                </div>
            <?php endif ?>
            <button class="comment-next-sibling-toggler comment-button">
                svara
            </button>
            <div class="comment-reply-form noshow" method="post">
                <textarea name="comment-new-text" cols="25" rows="3"></textarea>
                <br>
                <input type="hidden" name="parent-id" value="<?= $comment->id ?>">
                <input type="submit" name="new-comment-submitted" value="Svara">
            </div>
        </form>
    <?php endif ?>

    <?php if (isset($commentGroups[$comment->id])) : ?>
        <?php
            $comments = $commentGroups[$comment->id];
            include __DIR__.'/commentlist.php';
        ?>
    <?php endif ?>
</li>
