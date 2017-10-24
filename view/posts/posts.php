<?php if (isset($tag)) : ?>
    <h2>>> <?= htmlspecialchars($tag) ?></h2>
<?php endif ?>

<?php foreach ($posts as $post) : ?>
    <p>
        <a href="<?= $this->di->get('url')->create('post/show/'.$post->id) ?>">
            <span class="post-list-post-heading"><?= htmlspecialchars($post->subject) ?></span>
        </a>
        <br>
        <span class="smaller-text">
            av <a href="<?= $this->di->get('url')->create('user/profile/'.$post->author) ?>">
                    <?= $post->author ?: $post->authorEmail ?>
                </a>
            @ <?= $post->created ?><?= !is_null($post->updated) ? "& $post->updated" : "" ?>
        </span>
        <br>
        <span>
            <?= $post->points ?> poäng,
        </span>
        <a href="<?= $this->di->get('url')->create('post/show/'.$post->id."#comments") ?>">
            <span>
                <?= $post->nrOfComments ?> kommentarer
            </span>
        </a>
    </p>
<?php endforeach ?>
