<div class="post-comments">

    <?php if ($user->isUser) : ?>
    <form class="comment-top-reply-form" method="post">
        <textarea name="comment-new-text" cols="25" rows="3"></textarea>
        <br>
        <input type="hidden" name="parent-id" value="0">
        <input class="button" type="submit" name="new-comment-submitted" value="Svara">
    </form>
    <?php else : ?>
        <p>Logga in för att kommentera</p>
    <?php endif ?>

    <?php if (isset($commentGroups[0])) : ?>
        <?php
            $comments = $commentGroups[0];
            include __DIR__.'/commentlist.php';
        ?>
    <?php endif ?>

    <script>

    </script>
</div>
